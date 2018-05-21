<?php
namespace ReadPDFTest;

use PHPUnit\Framework\TestCase;
use ReadPDF\ReadPDF;
use ReadPDF\Exceptions\FindException;
use ReadPDF\Exceptions\ReadException;

class ReadPDFTest extends TestCase{
    public function testPDFRead(){
        $this->expectException(FindException::class);
        $p = new ReadPDF('tests/pdf/filetest1.pdf');
        
    }
    public function testCanGetInfo(){
        $this->expectException(ReadException::class);
        $p = new ReadPDF('tests/pdf/filetest3.pdf');
        
    }
    public function testGetPDFTrue(){
        $p = new ReadPDF('tests/pdf/filetest.pdf');
       $this->assertSame(true,method_exists($p, 'getAllInfo'));

    }
    public function testgetAllInfo(){
        $arr = array();
        $p = new ReadPDF('tests/pdf/filetest.pdf');
        $this->assertSame(['Title'=>"Test Package",
                            'Author'=>"NguyenPhiHuy",
                            'Creator'=>"pdftest.php",
                            'CreationDate'=>"D:20180509100339+07'00'",
                            'Producer'=>"PDFlib Personalization Server 9.1.2p1 (PHP7/Win32) unlicensed"
                            ],$p->getAllInfo());
    }
     public function testgetInfoByKey(){
        $arr = array();
        $p = new ReadPDF('tests/pdf/filetest.pdf');
        $this->assertSame('Test Package',$p->getInfoByKey('Title'));
        $this->assertSame('NguyenPhiHuy',$p->getInfoByKey('Author'));
        $this->assertSame('pdftest.php',$p->getInfoByKey('Creator'));
        $this->assertSame("D:20180509100339+07'00'",$p->getInfoByKey('CreationDate'));
    }



}
 ?>