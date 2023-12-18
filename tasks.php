<?php

class test
{
    public $next;
    public $x;
    public function __construct(int $x)
    {
        $this->x = $x;
    }
}

function task1($array, $n)
{
    $a = new test(1);
    $b = new test(2);
    $c = new test(3);
    $a->next = $b;
    $b->next = $c;
    $c->next = null;

    $objects = [];
    $objects[] = $a;
    $obj = $a;
    while ($obj->next !== null) {
        $objects[] = $obj->next;
        $obj = $obj->next;
    }

    foreach ($objects as $key => $object) {
        if ($key == 0) {
            $object->next = null;
        } elseif(isset($objects[$key-1])) {
            $object->next = $objects[$key-1];
        }
    }

    var_dump($objects[count($objects) -1]);
}

function task2($array, $n)
{
    sort($array);
    $countDelivery = 0;

    foreach ($array as $key => $item) {

        for ($key2 = count($array) - 1; $key2 > $key; $key2--) {
            if ($array[$key2] > $n) {
                removeItem($array, $key2);
                continue;
            }

            if (($array[$key2] + $item) == $n) {
                $countDelivery++;
                removeItem($array, $key2);
                break;
            }

            if (($array[$key2] + $item) < $n) {
                break;
            }
        }
    }

    sprintf('Mаксимальное количество выездов курьера %d', $countDelivery);
}

function removeItem($array, $key): array
{
    unset($array[$key]);
    return array_values($array);
}