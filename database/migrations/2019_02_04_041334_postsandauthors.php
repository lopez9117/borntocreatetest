<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Postsandauthors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

                   DB::statement("
            CREATE VIEW postsandauthors 
            AS
            SELECT
                posts.id AS id,
                posts.title As title,
                authors.firstName AS firstName,
                authors.lastName AS lastName,
                posts.content AS content,
                posts.published_at AS published_at
              
            FROM
                posts
                INNER JOIN authors ON posts.author_id = authors.id
             
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
