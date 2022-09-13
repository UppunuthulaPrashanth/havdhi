<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    protected $table = 'privacy_policy';
    protected $primaryKey = 'id';
    public $timestamps = false;

	protected $appends = ['privacy_policy'];
	
    public function getPrivacyPolicyAttribute()
    {
        $lang = \App\Lang::where('lang_prefix',request()->lang)->first();
        if($lang){
            return $this->attributes['privacy_policy'] = $this->attributes[request()->lang.'_privacy_policy'];
        }else{
            return $this->attributes['privacy_policy'];
        }
    }


    
}