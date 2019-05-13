<?php

use PragmaRX\Tracker\Support\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateTrackerSqlQueriesLogTable extends Migration
{
    /**
     * Table related to this migration.
     *
     * @var string
     */
    private $table = 'tracker_sql_queries_log';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function migrateUp()
    {
        Schema::create(
            $this->table,
            function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->bigInteger('log_id')->unsigned()->index();
                $table->bigInteger('sql_query_id')->unsigned()->index();

                $table->timestamps();
                $table->index('created_at');
                $table->index('updated_at');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function migrateDown()
    {
        Schema::dropIfExists($this->table);
    }
}
