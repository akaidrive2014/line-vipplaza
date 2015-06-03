<?php
/**
 * Created by PhpStorm.
 * User: syarif
 * Date: 1/12/15
 * Time: 2:02 PM
 */
Class StoreController extends VipplazaController{
    //testing
    public function actionIndex(){
        if(isset($_GET['sample'])){
            $data = json_encode(Vipplaza::sampleEventByCategory());
            $data = json_decode($data);
            echo "<pre>";
            print_r($data->bags);
            exit;

            $data = json_encode(Vipplaza::sampleIndexData());
            $data = json_decode($data);
            foreach($data as $val){
                echo $val->event_banner_image.'<br>';
            }
            exit;
        }
        if(isset($_GET['sample-detail2'])){
            //$data = json_encode(Vipplaza::sampleDetailData());
            //print_r($data);exit;
            $url = file_get_contents("http://line.vipplaza.lc/src/test_detail.html");
            echo ($url->entity_id);exit;
            echo $url->entity_id;exit;
            $data = str_replace('array(64)','',$url);
            $data = json_encode($data);
            $data = json_decode($data);
            //echo $data->entity_id;exit;
            print_r($data);
        }
        if(isset($_GET['sample-detail3'])){
            $url = file_get_contents('http://dev.testingdulu.com/vipline/index/index/id/37258');
            //$url = json_encode($url);
            $data = json_decode($url);
            echo $data->sku;
            exit;
            $url = file_get_contents("http://line.vipplaza.lc/src/test.html");
            //echo $url;exit;
            $data = json_decode($url);
            //print_r($data);exit;
            echo $data->product_name;
        }
        if(isset($_GET['sample-detail'])){
            $data = Vipplaza::sampleDetailData();
            $data = json_encode($data);
            $data = json_decode($data);
            $this->render('detail',array('data'=>$data));
            exit;

            $url = file_get_contents("http://dev.testingdulu.com/vipline/index/index/id/37258");
            //echo "<pre>";
            //print_r($url);exit;
            foreach($url as $data){
                echo $data->name;
            }
        }
        exit("404");
        $this->render('index');
    }

    //product by category
    public function actionCategory(){
        $Products = Vipplaza::getProduct();
        $this->render('category',array('Products'=>$Products));
    }

    //create html

    public function actionProductdetail($id){
        //$url = file_get_contents('http://dev.testingdulu.com/vipline/index/index/id/37258');
        $url = file_get_contents("http://dev.testingdulu.com/vipline/index/index/id/{$id}");
        $data = json_decode($url);
        //echo $data->image;exit;
        $this->render('detail',array('data'=>$data));
    }

    public function actionAddtocart($id){
        $url = file_get_contents("http://dev.testingdulu.com/vipline/index/index/id/{$id}");
        if(!empty($url)){
            exit($url);
        }
        exit("404");
    }

    //call sample : http://line.vipplaza.lc/store/createindex
    public function actionCreateindex(){
        $name = "index";
        $data = json_encode(Vipplaza::sampleIndexData());
        $data = json_decode($data);
        if(!empty($data)){
            $fileName = $ourFileName = "{$name}.html";
            $fh = fopen($fileName, 'w') or die("can't open file");
            $stringData = $this->setHtmlIndex($data);
            $create = fwrite($fh, $stringData);
            fclose($fh);
        }
        exit("success");
    }


    //call sample : http://line.vipplaza.lc/store/createcategory/name/nike-collection-abc?category=nike
    public function actionCreatecategory($name){
        $data = json_encode(Vipplaza::sampleEventByCategory());
        $data = json_decode($data);
        $category = $_GET['category'];
        $data = $data->{$category};
        if(!empty($data)){
            $fileName = $ourFileName = "{$name}.html";
            $fh = fopen($fileName, 'w') or die("can't open file");
            $stringData = $this->setHtmlCategory($data);
            $create = fwrite($fh, $stringData);
            fclose($fh);
        }
        exit("success");
    }

    protected function setHtmlIndex($data){
        return $this->renderPartial('_setHtmlIndex',array('data'=>$data),true);
    }

    protected function setHtmlCategory($data){
        return $this->renderPartial('_setHtmlCategory',array('data'=>$data),true);
    }

}