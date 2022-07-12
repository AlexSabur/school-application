<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Responses\PullChangesResponse;
use App\Models\Report\Record;
use App\Models\Report\Report;
use App\Models\Report\Violation;
use App\Models\Student\Classroom;
use App\Models\Student\Student;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Sajya\Server\Procedure;

class DatabaseProcedure extends Procedure
{
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'database';

    protected $mapping = [
        'violations' => Violation::class,
        'reports' => Report::class,
        'classrooms' => Classroom::class,
        'students' => Student::class,
        'records' => Record::class,
    ];

    /**
     * Execute the procedure.
     *
     * @param Request $request
     *
     * @return array|string|integer
     */
    public function load(Request $request)
    {
        $data = [];

        foreach ($this->mapping as $key => $value) {
            $data[$key] = forward_static_call([$value, 'all']);
        }

        return $data;
    }

    /**
     * Получить изменения с клиента
     *
     * @param Request $request
     *
     * @return void
     */
    public function pushChanges(Request $request)
    {
        $changes = $request->input('changes', []);

        foreach ($changes as $key => $value) {
            $class = $this->mapping[$key];

            /** @var Builder */
            $query = forward_static_call([$class, 'query'])->withTrashed();

            foreach ($value['created'] as $key => $entityData) {
                forward_static_call([$class, 'create'], $this->mapping($entityData));
            }

            foreach ($value['updated'] as $key => $entityData) {
                $id = Arr::pull($entityData, 'id');

                /** @var Model */
                $model = $query->find($id);

                $model->update($this->mapping($entityData));
            }

            foreach ($value['deleted'] as $key => $entityId) {
                $model = forward_static_call([$class, 'findMany'], $entityId);

                $model->each->delete();
            }
        }
    }

    /**
     * Отправить на клиент
     *
     * @param Request $request
     *
     * @return void
     */
    public function pullChanges(Request $request)
    {
        $response =  new PullChangesResponse;
        $lastPulledAt = $request->last_pulled_at;

        if ($lastPulledAt === null) {
            $this->firstInit($response);

            return $response;
        }

        $lastPulledAt = Str::length((string) $lastPulledAt) === 13
            ? Date::createFromTimestampMs($lastPulledAt)
            : Date::createFromTimestamp($lastPulledAt);

        foreach ($this->mapping as $mapName => $class) {
            /** @var Builder */
            $query = forward_static_call([$class, 'query']);

            $response->setChange($mapName, [
                'created' => $query->where('created_at', '>', $lastPulledAt)->get(),
                'updated' => $query->where('updated_at', '>', $lastPulledAt)->whereColumn('created_at', '!=', 'updated_at')->get(),
                'deleted' => $query->onlyTrashed()->where('deleted_at', '>', $lastPulledAt)->pluck('id'),
            ]);
        }

        return $response;
    }

    public function mapping($entityData)
    {
        return collect($entityData)
            ->filter(fn ($value, $key) => !Str::startsWith($key, '_'))
            ->map(function ($value, $key) {
                if (Str::endsWith($key, '_at')) {
                    if (is_numeric($value) && Str::length((string) $value) === 13) {
                        return intdiv($value, 1000);
                    }

                    return $value;
                }

                return $value;
            })
            ->toArray();
    }

    private function firstInit(PullChangesResponse $response)
    {
        foreach ($this->mapping as $mapName => $class) {
            $response->setChange($mapName, [
                'created' => forward_static_call([$class, 'all']),
                'updated' => [],
                'deleted' => [],
            ]);
        }
    }
}
