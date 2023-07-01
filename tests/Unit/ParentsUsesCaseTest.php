<?php

namespace Tests\Unit;

use App\Http\Controllers\AdminPortal\ParentsController;
use App\Http\Requests\AdminPortal\ListParentRequest;
use App\Services\ParentsService;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

class ParentsUsesCaseTest extends TestCase
{


    function testValidationResponseForListParentsWithEmptyRequest(){
        $response = $this->get('/api/v1/users');
        $response->assertStatus(422);
    }

    function testFailedListParents(){
       $this->json('GET', '/api/v1/users',['offset' => 0, 'limit' => 50])
            ->assertStatus(500);
    }
}
