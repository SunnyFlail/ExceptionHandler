<?php

namespace SunnyFlail\ErrorHandler\Test;

class Test
{

    public function test(?string $opt)
    {
        throw new SuperError("Super error occured... What can we do???");
    }


}