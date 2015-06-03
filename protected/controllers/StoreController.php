<?php
/**
 * Created by PhpStorm.
 * User: syarif
 * Date: 1/12/15
 * Time: 2:02 PM
 */
Class StoreController extends VipplazaController{
    //create html
    public function dataTest(){
        return $url = file_get_contents("http://line.vipplaza.lc/src/product-detail.html");
    }
    public function actionProductdetail($id){
        //$url = file_get_contents('http://dev.testingdulu.com/vipline/index/index/id/37258');
        $url = file_get_contents($this->url_line_vipplaza."vipline/index/index/id/{$id}");
        $data = json_decode($url);
        $this->renderPartial('detail',array('data'=>$data));
    }
    public function actionAddtocart(){
        $product_id = $_POST['product'];
        $product_type = $_POST['product_type'];
        if($product_type=="configurable") {
            $attribute_id = $_POST['attribute_id'];
            $attribute_value = $_POST['super_attribute'][$attribute_id];
        }
        $qty = $_POST['qty'];

        $model = New Cart;
        $model->product_id = $product_id;
        $model->product_type = $product_type;
        if($product_type=="configurable") {
            $model->attribute_id = $attribute_id;
            $model->attribute_value = $attribute_value;
        }
        $model->qty = $qty;

        if($model->validate()){
            $url = $product_type=='configurable' ? $this->url_line_vipplaza."vipline/index/lineAddtoCart/product_id/{$product_id}/attribute_id/{$attribute_id}/attribute_value/{$attribute_value}/qty/{$qty}" : $this->url_line_vipplaza."vipline/lineAddtoCart/product_id/{$product_id}/qty/{$qty}";
            exit(json_encode(array(
                'success'=>true,
                'url'=>$url."?utm_source=line&utm_medium=banner&utm_campaign=lineshopping"
            )));
        }else{
            exit(CActiveForm::validate($model));
        }
    }

    //call url : http://line.vipplaza.lc/store/createProductdetail/fileName/{fileName}
    public function actionCreateProductdetail($fileName){
        $file = $this->checkFile($fileName);
        $Data = Vipplaza::getFileData($file);
        $DataProduct = array();
        if(!empty($Data)){
            foreach($Data as $index=>$data){
                if(!empty($Data[$index])){
                    $id = $Data[$index][0];
                    $url = file_get_contents($this->url_line_vipplaza."vipline/index/index/id/{$id}");
                    $data = json_decode($url);
                    $slug = $data->entity_id.'-'.Vipplaza::url_title($data->name);
                    $fileName = $ourFileName = "{$slug}.html";
                    $fh = fopen($fileName, 'w') or die("can't open file");
                    $stringData = $this->setHtmlProductDetail($data);
                    $create = fwrite($fh, $stringData);
                    $close = fclose($fh);
                    if($close){
                        echo $index.". Created <a target=\"_blank\" href=\"{$this->baseUrl()}/{$fileName}\">{$this->baseUrl()}/{$fileName}</a><br>";
                    }
                }
            }
            exit('Success');
        }
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
    public function actionCreatecategory($fileName){
        $file = $this->checkFile($fileName);
        $Data = Vipplaza::getFileData($file);
        $DataProduct = array();
        if(!empty($Data)){
            foreach($Data as $index=>$data){
                if(!empty($Data[$index])){
                    $id = $Data[$index][0];
                    $url = file_get_contents($this->url_line_vipplaza."vipline/index/index/id/{$id}");
                    $DataProduct[]=$url;
                }
            }
        }
        $data = json_encode($DataProduct);
        $data = json_decode($data);
        $slug  = '';
        if(isset($_GET['slug'])){
            $slug = $_GET['slug'];
        }else{throw new CHttpException(404,'The requested page does not exist.');}

        $fileName = $ourFileName = "{$slug}.html";
        $fh = fopen($fileName, 'w') or die("can't open file");
        $stringData = $this->setHtmlCategory($data);
        $create = fwrite($fh, $stringData);
        $close = fclose($fh);

        if($close){
            exit("success");
        }else{
            throw new CHttpException(404,'The requested page does not exist.');
        }
    }

    protected function setHtmlIndex($data){
        return $this->renderPartial('_setHtmlIndex',array('data'=>$data),true);
    }

    protected function setHtmlCategory($data){
        return $this->renderPartial('_setHtmlCategory',array('data'=>$data),true);
    }

    protected function setHtmlProductDetail($data){
        return $this->renderPartial('_setHtmlProductDetail',array('data'=>$data),true);
    }

    public function checkFile($file){
        if(empty($file))
            throw new CHttpException(404,'The requested page does not exist.');
        return $file;
    }

}