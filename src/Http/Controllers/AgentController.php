<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\InternationalTransfer\Contracts\FeeConfiguration;
use Kanexy\InternationalTransfer\Enums\Fee;
use Kanexy\InternationalTransfer\Enums\Status;
use Kanexy\InternationalTransfer\Http\Helper;
use Kanexy\InternationalTransfer\Http\Requests\StoreFeeRequest;
use Kanexy\InternationalTransfer\Policies\FeePolicy;

class AgentController extends Controller
{
    public function index()
    {
        return view("international-transfer::agents.agent-request");
    }

    public function agentRequest()
    {
        return view("international-transfer::agents.agent-request");
    }
}
