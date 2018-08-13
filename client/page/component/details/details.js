// page/component/details/details.js
var config = require('../../../config')
Page({

  /**
   * 页面的初始数据
   */
  data: {
    goods: {
      id: 1,
      image: '/image/goods1.png',
      title: '新鲜梨花带雨',
      price: 0.01,
      stock: '有货',
      detail: '这里是梨花带雨详情。',
      parameter: '125g/个',
      service: '不支持退货'
    },
    goodsID: 0,
    goodsData: [],
    num: 1,
    totalNum: 0,
    hasCarts: false,
    curIndex: 0,
    show: false,
    scaleCart: false
  },

  addCount() {
    let num = this.data.num;
    num++;
    this.setData({
      num: num
    })
  },

  addToCart() {
    const self = this;
    const num = this.data.num;
    let total = this.data.totalNum;

    var cur_num = num + total;
    this.data.totalNum = cur_num;

    self.setData({
      show: true,
      totalNum: cur_num
    })
    setTimeout(function () {
      self.setData({
        show: false,
        scaleCart: true
      })
      setTimeout(function () {
        self.setData({
          scaleCart: false,
          hasCarts: true
        });
      }, 200)
    }, 300);
    this.setDataToStorage();
  },

  bindTap(e) {
    const index = parseInt(e.currentTarget.dataset.index);
    this.setData({
      curIndex: index
    })
  },

  /**
   * 生命周期函数--监听页面加载
   */

  setDataToStorage: function () {
    var cur_cart = [];
    cur_cart = wx.getStorageSync('cart') == '' ? [] : wx.getStorageSync('cart');
  
    var b_find = false;
    for(var i=0;i<cur_cart.length;i++){
      var row = cur_cart[i];
      if(row.id==this.data.goodsID){
        cur_cart[i]['num'] = this.data.totalNum;
        b_find = true;
      }
    }
    if(!b_find){
      cur_cart.push({ id: this.data.goodsID, title: this.data.goodsData.p_name + ' ' + this.data.goodsData.guige_name, image: this.data.goodsData.photo_x, num: this.data.totalNum, price: this.data.goodsData.stock_price, selected: true});
    }
    wx.setStorageSync('cart', cur_cart);
    console.log(cur_cart);
  },

  onLoad: function (options) {
    var goods_id = options.goods_id;
    this.setData({ goodsID: goods_id });
    this.loadGoodsDetail(goods_id);
  },

  loadGoodsDetail: function (goods_id) {
    var page = this;
    wx.request({
      url: config.service.host + '/Production_interface/get_goods_info',
      data: { goods_id: goods_id },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        page.setData({ goodsData: res.data[0] })
        console.log(res.data[0]);

        // wx.hideToast();
        /*
        WxParse.wxParse('goods_brief', 'html', res.data.data.goodsinfo.goods_brief, page, 5);
        page.setData({
          goodsInfo: res.data.data.goodsinfo,
          groupInfo: res.data.data.groupInfo
        });
        wx.setStorageSync('goods_id', goods_id);
        */
      },
      fail: function (res) {
        // fail
      }
    })
  }
})