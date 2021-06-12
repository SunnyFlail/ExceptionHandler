<?php

namespace SunnyFlail\ExceptionHandler\Test;

class Test
{

    public function test(?string $opt)
    {
        throw new SuperError("Super error occured... What can we do???");
    }


}