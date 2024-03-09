<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VendorAPITest extends TestCase
{   
    public function setUp(): void
    {
        parent::setUp();
        
        Storage::fake('public');
    }

    //
}