<?php namespace App\Traits;

/**
 * Проверка прав доступы
 */
trait UserTrait
{

  /**
   * Read
   */

    public function checkRead ($object = null)
    {
      if ($this->role->name != 'admin') {
        $permission = $this->role->permissions->where('model', $object->getModelName());

        if (!is_null($object->id)) {
          $permission = $permission->where('model_id', $object->id);
        }

        $permission = $permission->where('read', 1)->first();

        return ($permission) ? true : false;
      }
      return true;
    }

  /**
   * Add
   */

    public function checkCreate ($object = null)
    {
      if ($this->role->name != 'admin') {
        $permission = $this->role->permissions->where('model', $object->getModelName());

        if (!is_null($object->id)) {
          $permission = $permission->where('model_id', $object->id);
        }

        $permission = $permission->where('add', 1)->first();

        return ($permission) ? true : false;
      }
      return true;
    }
  /**
   * Edit
   */

    public function checkUpdate ($object = null)
    {
      if ($this->role->name != 'admin') {
        $permission = $this->role->permissions->where('model', $object->getModelName());

        if (!is_null($object->id)) {
          $permission = $permission->where('model_id', $object->id);
        }

        $permission = $permission->where('edit', 1)->first();

        return ($permission) ? true : false;
      }
      return true;
    }

  /**
   * Delete
   */

    public function checkDelete ($object = null)
    {
      if ($this->role->name != 'admin') {
        $permission = $this->role->permissions->where('model', $object->getModelName());

        if (!is_null($object->id)) {
          $permission = $permission->where('model_id', $object->id);
        }

        $permission = $permission->where('delete', 1)->first();

        return ($permission) ? true : false;
      }
      return true;
    }

}
