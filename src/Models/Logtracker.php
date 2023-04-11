<?php

namespace phGov\Auditlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logtracker extends Model
{
    use HasFactory;
    protected $table = 'logtrackers';
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    

    public $timestamps = false;
    public $dates = ['log_date'];
    protected $appends = ['dateHumanize','json_data'];

    private $userInstance = "\App\Models\User";
    private $officeInstance = "\App\Models\Office";
    private $officeLayerInstance = "\App\Models\OfficeLayer";
    private $officeMinistryInstance = "\App\Models\OfficeMinistry";
    private $geoRegionInstance = "\App\Models\GeoRegion";
    private $geoProvienceInstance = "\App\Models\GeoProvience";
    private $geoMunicipalityInstance = "\App\Models\GeoMunicipality";
    private $geoBarangayInstance = "\App\Models\GeoBarangay";

    public function __construct() {
        $userInstance = ''; // Will be dynamic for package
        if(!empty($userInstance)) $this->userInstance = $userInstance;
    }
    public function getDateHumanizeAttribute()
    {
        return $this->log_date->diffForHumans();
    }
    public function getJsonDataAttribute()
    {
        return json_decode($this->data,true);
    }
    public function user()
    {
        return $this->belongsTo($this->userInstance);
    }
    public function office()
    {
        return $this->belongsTo($this->officeInstance);
    }
    public function officeLayer()
    {
        return $this->belongsTo($this->officeLayerInstance);
    }
    public function officeMinistry()
    {
        return $this->belongsTo($this->officeMinistryInstance);
    }
    public function geoRegion()
    {
        return $this->belongsTo($this->geoRegionInstance);
    }
    public function geoProvience()
    {
        return $this->belongsTo($this->geoProvienceInstance);
    }
    public function geoMunicipality()
    {
        return $this->belongsTo($this->geoMunicipalityInstance);
    }
    public function geoBarangay()
    {
        return $this->belongsTo($this->geoBarangayInstance);
    }
    

    public function scopeOrderByName($query)
    {
        $query->orderBy('log_date','DESC');
    }
    public function scopeCustomPagination($query, array $filters) 
    {
        $query->when($filters['length'] ?? null, function ($query, $length) {
            $query->paginate($length);
        });
    }
    
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('table_name', 'like', '%'.$search.'%')
                    ->orWhere('log_type', 'like', '%'.$search.'%')
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%'.$search.'%');
                    });                   
            });
        })->when($filters['user_id'] ?? null, function ($query, $user_id) {            
            $query->where('user_id', '=', $user_id);
        })->when($filters['office_layer_id'] ?? null, function ($query, $office_layer_id) {            
            $query->where('office_layer_id', '=', $office_layer_id);
        })->when($filters['office_id'] ?? null, function ($query, $office_id) {            
            $query->where('office_id', '=', $office_id);
        })->when($filters['ministry_id'] ?? null, function ($query, $ministry_id) {            
            $query->where('ministry_id', '=', $ministry_id);
        })->when($filters['region_id'] ?? null, function ($query, $region_id) {            
            $query->where('region_id', '=', $region_id);
        })->when($filters['province_id'] ?? null, function ($query, $province_id) {            
            $query->where('province_id', '=', $province_id);
        })->when($filters['municipality_id'] ?? null, function ($query, $municipality_id) {            
            $query->where('municipality_id', '=', $municipality_id);
        })->when($filters['barangay_id'] ?? null, function ($query, $barangay_id) {            
            $query->where('barangay_id', '=', $barangay_id);
        })->when($filters['designation_id'] ?? null, function ($query, $designation_id) {            
            $query->where('designation_id', '=', $designation_id);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }


}
