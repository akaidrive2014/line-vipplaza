<?php

/**
 * Created by PhpStorm.
 * User: syarif
 * Date: 1/12/15
 * Time: 1:37 PM
 */
Class TestController extends VipplazaController
{
	
	public function actionGet(){
		$data = file_get_contents("http://mage-mage.lc/testing/index/maenandata");
		echo $data->name;;
	}
	
    public function actionGethtml(){
        header("Content-Type:text/plain");
        $myFile = "src/html_format.txt";
        $fh = fopen($myFile, 'r');
        $theData = fread($fh, filesize($myFile));
        fclose($fh);
        return $theData;
    }

    public function formatHtml(){
        return "";
    }

    public function actionCreate($name){
        $myFile = $ourFileName = "{$name}.html";
        $fh = fopen($myFile, 'w') or die("can't open file");
        $stringData = $this->renderPartial('create',array(),true);
        $create = fwrite($fh, $stringData);
        fclose($fh);
        exit;
        $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
        fclose($ourFileHandle);
    }

    public function actionUpdate($name){
        $myFile = "{$name}.html";
        $fh = fopen($myFile, 'w') or die("can't open file");
        $stringData = $this->actionGethtml();
        fwrite($fh, $stringData);
        fclose($fh);
    }

    public function actionGetdetail()
    {
        //header("Content-Type:text/plain");

        //echo "<b>TEST</b>";exit;

        $HTML = $this->readHTML('http://www.vipplaza.com/vesperine-kansen-grape-blouse-55578.html');
        // a new dom object
        $dom = new domDocument;
        // load the html into the object
        $dom->loadHTML('http://www.vipplaza.com/vesperine-kansen-grape-blouse-55578.html');
        // discard white space
        $dom->preserveWhiteSpace = false;
        $mango_div = $dom->getElementById('roll_on');
        echo $mango_div;

        exit;
        echo $HTML;
        exit;
        $explode = explode('<div class="product-img-box">', $HTML);
        $explode_1 = explode('</div>', $explode[1]);
        echo $explode_1[0];
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

    public function actionIndex()
    {
        exit('It Works');
    }

    public function actionRead(){
        $file="src/catalog.txt";
        $fopen = fopen($file, 'r');
        $fread = fread($fopen,filesize($file));
        fclose($fopen);
        $remove = "\n";
        $split = explode($remove, $fread);

        $array[] = null;
        $tab = "\t";

        foreach ($split as $string)
        {
            $row = explode($tab, $string);
            array_push($array,$row);
        }
        echo "<pre>";
        //$data = json_encode($array);
        foreach($array as $index=>$data){
            if(!empty($array[$index])){
                echo $index;
                echo $array[$index][0].'<br>';
            }
        }exit;
        echo $array[3][0];exit;
        print_r($array);
        echo "</pre>";
        /*$content = "src/catalog.txt";
        $data = file_get_contents($content);
        $data = nl2br($data);
        $data = explode('<br>',$data);
        echo count($data);*/
    }

    public function actionReadfile()
    {
        $content = "src/url.xml";
        $XML = simplexml_load_file($content);

        if (!empty($XML->url)) {
            foreach ($XML->url as $product) {
                $FeedData = simplexml_load_file("http://ftr.fivefilters.org/makefulltextfeed.php?url={$product->loc}");
                if (!empty($product->loc)) {
                    $FeedData = $FeedData->channel->item;
                    //echo $FeedData->description;
                    echo Vipplaza::Takechar($FeedData->description).'<hr>';
                    /*
                    $product_title = str_replace(array("http://www.vipplaza.com/",'.html'),'',$product->loc);
                    $product_title = explode("-",$product_title);
                    $product_title = implode(" ",$product_title);
                    $product_title = preg_replace("/[^a-z ]/", '',$product_title);
                    echo Vipplaza::Takechar($FeedData->description);
                    *///echo strtoupper($product_title).'<br>';
                }
            }
        }
    }

    public function actionDisplay(){
        $data = Vipplaza::getProduct();
        if(!empty($data)){
            foreach($data as $product){
                echo Vipplaza::getProductName($product->loc);
            }
        }
    }
}