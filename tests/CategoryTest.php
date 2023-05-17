<?php

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

final class CategoryTest extends TestCase
{
    public function testCanSetName(): void
    {
        $name = "Mon Nom";

        $category = (new Category)->setName($name);

        $this->assertSame($name, $category->getName());
    }
}