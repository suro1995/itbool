<?php
/****
燕十八 公益PHP讲堂

论  坛: http://www.zixue.it
微  博: http://weibo.com/Yshiba
YY频道: 88354001
****/


defined('ACC')||exit('ACC Denied');

class GoodsModel extends Model{
    protected $table = 'goods';
    protected $pk = 'goods_id';
    protected $fields = array('goods_id','goods_sn','cat_id','brand_id','goods_name','shop_price','market_price','goods_number','click_count','goods_weight','goods_brief','goods_desc','thumb_img','goods_img','ori_img','is_on_sale','is_delete','is_best','is_new','is_hot','add_time','last_update');

    protected $_auto = array(
                            array('is_hot','value',0),
                            array('is_new','value',0),
                            array('is_best','value',0),
                            array('add_time','function','time')
                            );

    protected $_valid = array(
                            array('goods_name',1,'必须有商品名','require'),
                            array('cat_id',1,'栏目id必须是整型值','number'),
                            array('is_new',0,'is_new只能是0或1','in','0,1'),
                            array('goods_brief',2,'商品简介就在10到100字符','length','10,100')
    );


    /*
        作用:把商品放到回收站,即is_delete字段置为1
        parm int id
        return bool
    */
    public function trash($id) {
        return $this->update(array('is_delete'=>1),$id);
    }


    public function getGoods() {
        $sql = 'select * from goods where is_delete=0';
        return $this->db->getAll($sql);
    }

    public function getTrash() {
        $sql = 'select * from goods where is_delete=1';
        return $this->db->getAll($sql);
    }

    /** 创建商品的货号**/
    public function createSn() {
        $sn = 'BL' . date('Ymd') . mt_rand(10000,99999);

        $sql = 'select count(*) from ' . $this->table . " where goods_sn='" . $sn . "'";
        
        return $this->db->getOne($sql)?$this->createSn():$sn;
    }
}

