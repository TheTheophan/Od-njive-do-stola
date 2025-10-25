<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    
    public function scopeSearchLatestPaginated(
        Builder $query,
        ?string $search,
        int $paginationQuantity = 10
    ): Builder {
        if (empty($search)) {
            return $query->orderBy('updated_at', 'desc')->paginate($paginationQuantity);
        }

        return $query
            ->search($search)
            ->orderBy('updated_at', 'desc')
            ->paginate($paginationQuantity);
    }

    
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if ($search === null || $search === '') {
            return $query;
        }

        $query->where(function ($query) use ($search) {
            foreach ($this->getSearchableFields() as $field) {
                $query->orWhere($field, 'like', "%{$search}%");
            }
        });

        return $query;
    }

    
    protected function getSearchableFields(): array
    {
        if (isset($this->searchableFields) && count($this->searchableFields)) {
            return $this->searchableFields[0] === '*'
                ? $this->getAllModelTableFields()
                : $this->searchableFields;
        }

        return $this->getAllModelTableFields();
    }

    
    protected function getAllModelTableFields(): array
    {
        $tableName = $this->getTable();

        return $this->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($tableName);
    }
}
