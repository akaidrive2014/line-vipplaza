<?php

/**
 * Created by PhpStorm.
 * User: syarif
 * Date: 1/12/15
 * Time: 10:49 AM
 */
Class xTestController extends VipplazaController
{

    public function actionIndex()
    {
        exit('It Works');
    }

    /*
    public function actionReadfile2()
    {
        $content = "src/url.xml";
        $xml = file_get_contents($content);
        $data = $xml->urlset->url;

        print_r($data);exit;

        foreach($data as $url){
            echo $url->loc;
        }
    }*/

    public function actionReadfile()
    {
        exit("Test");
        /*$content = "src/url.xml";
        $XML = simplexml_load_file($content);

        foreach($XML->url as $xml){
            echo $xml->loc;
        }*/
    }

    public function actionGetlist()
    {
        header("Content-Type:text/plain");
        $HTML = $this->readHTML('http://www.vipplaza.com/all-events/02030209/vesperine.html');
        $Explode = explode('<div class="holder" style="position:relative; height: 100%;">', $HTML);
        print_r($Explode);

        echo $HTML;
    }



    public function actionGetlist()
    {
        header("Content-Type:text/plain");
        $HTML = $this->readHTML('http://www.vipplaza.com/all-events/02030209/vesperine.html');
        $Explode = explode('<div class="holder" style="position:relative; height: 100%;">', $HTML);
        print_r($Explode);
        exit;
        echo $HTML;
    }

    public function actionGetdetail()
    {
        //header("Content-Type:text/plain");

        //echo "<b>TEST</b>";exit;

        $HTML = $this->readHTML('http://www.klikbca.com');
        //echo $kodeHTML;exit;
        $explode = explode('<table width="139" border="0" cellspacing="0" cellpadding="0">', $HTML);
        $explode_1 = explode('</table>', $explode[2]);
        $cReplace = array('<td align="right" class="kurs" bgcolor="#dcdcdc">', '<td align="right" class="kurs" bgcolor="#dcdcdc">', '<td align="left" class="kurs" bgcolor="#dcdcdc">', '<tr>', '<td>', '</tr>', '</td>');
        echo str_replace($cReplace, '', $explode_1[0]);
    }

    public function readHTML($url)
    {
        // inisialisasi CURL
        $data = curl_init();
        // setting CURL
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_URL, $url);
        // menjalankan CURL untuk membaca isi file
        $result = curl_exec($data);
        curl_close($data);
        return $result;
    }

}
/*
 * public function actionGetdetail()
    {
        header("Content-Type:text/plain");

        //echo "<b>TEST</b>";exit;

        $HTML = $this->readHTML('http://www.klikbca.com');
        //echo $kodeHTML;exit;
        $explode = explode('<table width="139" border="0" cellspacing="0" cellpadding="0">', $HTML);
        $explode_1 = explode('</table>', $explode[2]);
        echo $explode_1[0];



    }
 */