<?php

namespace App\BuildingBlocks\Actions;

use App\BuildingBlocks\Actions\Capabilities\WithHelpers;
use App\BuildingBlocks\Actions\Capabilities\WithMessageDispatcher;
use App\BuildingBlocks\Actions\Capabilities\WithOpenApiSchema;
use App\BuildingBlocks\Actions\Capabilities\WithPayload;
use App\BuildingBlocks\Actions\Capabilities\WithRequest;
use App\BuildingBlocks\Actions\Capabilities\WithRouting;
use App\BuildingBlocks\Actions\Capabilities\WithValidation;

trait ActionCapabilities
{
    use WithMessageDispatcher;
    use WithPayload;
    use WithRequest;
    use WithRouting;
    use WithValidation;
    use WithOpenApiSchema;
    use WithHelpers;
}
