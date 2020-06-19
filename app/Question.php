<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	protected $table = 'questions';
	protected $fillable = ['title','slug', 'body'];

	public function user() {
		return $this->belongsTo(User::class);
	}

	/*public function setTitelAttribute($value) {
		$this->attributes['title'] = $value ;
		$this->attributes['slug'] = str_slug($value);
	}*/

	public function getUrlAttribute() {
		return  route("questions.show", $this->slug);
	}

	public function getCreatedDateAttribute() {
    	return $this->created_at->diffForHumans(); // diff.. dung de hien thi ngay co dang two day ago
    }

    public function getStatusAttribute() {
    	if($this->answer >0) {
    		if($this->best_answer_id) {
    			return "answered-accepted";
    		}
    		return "answered";
    	}
    	return "unanswered";
    }

    public function getBodyHtmlAttribute() {
    	return \Parsedown::instance()->text($this->body);
    }
}
