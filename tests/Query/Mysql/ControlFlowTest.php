<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class ControlFlowTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testIfNull()
    {
        $q = $this->entityManager->createQuery("SELECT IFNULL(1, 1) from DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            "SELECT IFNULL(1, 1) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testConditionalIfNull()
    {
        $q = $this->entityManager->createQuery("SELECT IFNULL(b.id = 1, 1) from DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            "SELECT IFNULL(b0_.id = 1, 1) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
