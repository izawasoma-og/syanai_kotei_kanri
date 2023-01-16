<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( 'DROP VIEW IF EXISTS view_projects' );
        DB::statement( "CREATE VIEW view_projects AS
            SELECT
                projects.id AS 'id',
                projects.name AS 'project_name',
                clients.name AS 'client_name',
                project_types.name AS 'type_name',
                (SELECT TIME_FORMAT(SUM(working_time),'%H:%i')
                    FROM reports
                    WHERE DATE_FORMAT(date,'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m') AND reports.project_id = projects.id
                    GROUP BY project_id , DATE_FORMAT(date,'%Y-%m')) AS 'month1',
                (SELECT TIME_FORMAT(SUM(working_time),'%H:%i')
                    FROM reports
                    WHERE DATE_FORMAT(date,'%Y-%m') = DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH),'%Y-%m') AND reports.project_id = projects.id 
                    GROUP BY project_id , DATE_FORMAT(date,'%Y-%m')) AS 'month2',
                (SELECT TIME_FORMAT(SUM(working_time),'%H:%i')
                    FROM reports
                    WHERE DATE_FORMAT(date,'%Y-%m') = DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 2 MONTH),'%Y-%m') AND reports.project_id = projects.id
                    GROUP BY project_id , DATE_FORMAT(date,'%Y-%m')) AS 'month3',
                (SELECT TIME_FORMAT(SUM(working_time),'%H:%i')
                    FROM reports
                    WHERE reports.project_id = projects.id
                    GROUP BY project_id) AS 'sum'
            FROM projects
            INNER JOIN clients ON projects.client_id = clients.id
            INNER JOIN project_types ON projects.project_type_id = project_types.id;
        " );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_projects');
    }
};
