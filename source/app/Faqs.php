<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faqs extends Model
{
    protected $table = 'faq';
    protected $primaryKey = 'faq_id';
    public $timestamps = false;


	protected $appends = ['question','answer'];
    
    public function getQuestionAttribute()
    {
        $lang = \App\Lang::where('lang_prefix',request()->lang)->first();
        if($lang){
            return $this->attributes['question'] = $this->attributes[request()->lang.'_question'];
        }else{
            return $this->attributes['question'];
        }
    }
    
    public function getAnswerAttribute()
    {
        $lang = \App\Lang::where('lang_prefix',request()->lang)->first();
        if($lang){
            return $this->attributes['answer'] = $this->attributes[request()->lang.'_answer'];
        }else{
            return $this->attributes['answer'];
        }
    }
    
}