<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Tmpr\Chart\Domain\Repository\CsvCustomerDataRepository;
use Tmpr\Chart\Domain\Entity\UserEntity;



final class CsvCustomerDataRepositoryTest extends TestCase
{

    public function testInvalidFile()
    {
        try {
            $CsvCustomerDataRepository=new CsvCustomerDataRepository('../../resource/csv/test/export_invalid.csv');
            $CsvCustomerDataRepository->getAll();
        } catch (Exception $e) {
            $message=$e->getMessage();
        }
        $this->assertEquals($message,'invalid file path');
    }

    public function testEmptyFile()
    {
        $CsvCustomerDataRepository=new CsvCustomerDataRepository('../../resource/csv/test/empty.csv');
        $customerEntitySet=$CsvCustomerDataRepository->getAll();
        $this->assertEmpty($customerEntitySet);
    }

    public function testCorrectFile()
    {
        $CsvCustomerDataRepository=new CsvCustomerDataRepository('../../resource/csv/test/export_3.csv');
        $customerEntitySet=$CsvCustomerDataRepository->getAll();
        $this->assertContainsOnlyInstancesOf(UserEntity::class, $customerEntitySet);
    }
}

