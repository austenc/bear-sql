<?php

namespace App\Livewire;

use App\Models\Connection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class QueryEditor extends Component
{
    public Connection $connection;

    public $results;

    public $validQuery = false;

    public string $query;

    public function mount(Connection $connection)
    {
        $this->connection = $connection;
        $this->results = collect();

        // Debug
        $this->query = 'select * from users';
        $this->updatedQuery();
    }

    public function updatedQuery()
    {
        if (empty($this->query)) {
            return collect();
        }

        try {
            $this->results = collect()->wrap($this->currentConnection->select($this->query));
            $this->validQuery = true;
            $this->resetValidation('query');
        } catch (\Exception $e) {
            $this->validQuery = false;
            $this->results = collect();
            $this->addError('query', $e->getMessage());
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
        return view('livewire.query-editor');
    }
}
