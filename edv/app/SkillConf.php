<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; // :: setKeysForSaveQuery :: 

class SkillConf extends Model
{
  /**
   * Eloquent can't use composite keys (wtf!)
   * This is a solution to update properly
   * Source: https://blog.maqe.com/solved-eloquent-doesnt-support-composite-primary-keys-62b740120f
   */
  public $incrementing = false;
  protected function setKeysForSaveQuery(Builder $query)
  {
    $query
      ->where('userId', '=', $this->getAttribute('userId'))
      ->where('skillId', '=', $this->getAttribute('skillId'));
    return $query;
  }
}
