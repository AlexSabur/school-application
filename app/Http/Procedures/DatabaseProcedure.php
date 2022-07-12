<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Responses\PullChangesResponse;
use App\Models\Report\Record;
use App\Models\Report\Report;
use App\Models\Report\Violation;
use App\Models\Student\Classroom;
use App\Models\Student\Student;
use App\Models\UuidModel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
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
     * Получить изменения с клиента
     *
     * @param Request $request
     *
     * @return void
     */
    public function pushChanges(Request $request)
    {
        DB::transaction(function () use ($request) {
            $changes = $request->input('changes', []);

            foreach ($changes as $classKey => $changes) {
                /** @var UuidModel */
                $modelClass = $this->mapping[$classKey];

                foreach ($changes['created'] as $entityData) {
                    $modelClass::create($this->mapping($entityData));
                }

                foreach ($changes['updated'] as $entityData) {
                    $id = Arr::pull($entityData, 'id');

                    $modelClass::withTrashed()
                        ->findOrFail($id)
                        ->update($this->mapping($entityData));
                }

                $modelClass::withTrashed()
                    ->findMany($changes['deleted'])
                    ->each
                    ->delete();
            }
        });
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
            /** @var UuidModel $class */

            $response->setChange($mapName, [
                'created' => $class::query()->where('created_at', '>', $lastPulledAt)->get(),
                'updated' => $class::query()->where('updated_at', '>', $lastPulledAt)->whereColumn('created_at', '!=', 'updated_at')->get(),
                'deleted' => $class::query()->onlyTrashed()->where('deleted_at', '>', $lastPulledAt)->pluck('id'),
            ]);
        }

        return $response;
    }

    private function mapping(array $entityData): array
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

    private function firstInit(PullChangesResponse $response): PullChangesResponse
    {
        foreach ($this->mapping as $mapName => $class) {
            /** @var UuidModel $class */

            $response->setChange($mapName, [
                'created' => $class::all(),
                'updated' => [],
                'deleted' => [],
            ]);
        }

        return $response;
    }
}
