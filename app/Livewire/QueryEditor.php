<?php

namespace App\Livewire;

use App\Models\Connection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class QueryEditor extends Component
{
    public Connection $connection;

    public $validQuery = false;

    public $orderBy = null;

    public $direction = 'asc';

    public string $query;

    public function mount(Connection $connection)
    {
        $this->connection = $connection;

        // Debug
        $this->query = 'select * from users';
    }

    public function setOrderBy($col)
    {
        // if this is already the order by, toggle the direction
        if ($this->orderBy == $col) {

            // Cycle the direction, asc, desc, null
            if ($this->direction === 'desc') {
                $this->orderBy = null;
                $this->direction = null;

                return;
            }

            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';

            return;
        }

        $this->orderBy = $col;
        $this->direction = 'asc';
    }

    #[Computed]
    public function finalQuery()
    {
        return $this->currentConnection
            ->query()
            ->when($this->orderBy, function ($query) {
                return $query->orderBy($this->orderBy, $this->direction);
            })
            ->selectRaw(str($this->query)->trim()->replaceStart('select ', ''))
            ->get();
    }

    public function runQuery()
    {
        if (empty($this->query)) {
            return collect();
        }

        try {
            $results = collect()->wrap($this->finalQuery);
            $this->validQuery = true;
            $this->resetValidation('query');

            return $results;
        } catch (\Exception $e) {
            $this->validQuery = false;
            $this->addError('query', $e->getMessage());

            return collect();
        }
    }

    #[Computed]
    public function currentConnection()
    {
        config(['database.connections.current' => [
            'driver' => 'mysql',
            'host' => $this->connection->host,
            'port' => $this->connection->port,
            'database' => $this->connection->database,
            'username' => $this->connection->username,
            // 'password' => $this->connection->password,
        ]]);

        return DB::connection('current');
    }

    // #[Computed]
    // public function results()
    // {
    //     dump('results calll');
    //     if (empty($this->query)) {
    //         dd('wtf');

    //         return collect();
    //     }

    //     $results = collect();

    //     try {
    //         $this->validQuery = true;

    //         return $results->wrap($this->currentConnection->select($this->query));
    //     } catch (\Exception $e) {
    //         $this->validQuery = false;
    //         dump($e);
    //     }

    //     return $results;
    //     // dd($result);
    // }

    public function render()
    {
        return view('livewire.query-editor', [
            'results' => $this->runQuery(),
        ]);
    }
}
