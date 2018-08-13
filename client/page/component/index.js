// page/component/index.js
var config = require('../../config')

Page({

  /**
   * 页面的初始数据
   */
  data: {
    indicatorDots: false,
    autoplay: false,
    interval: 3000,
    duration: 800,
    swiperData: [],
    goodsData:[]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    this.loadSwiper();
    this.loadGoods();
  },

  //加载轮播图
  loadSwiper: function () {
    var page = this;
    var swiperData = [];
    wx.request({
      url: config.service.host + '/Swiper_interface/get_img_list',
      success: function (res) {
        var data = res.data;
        page.setData({ swiperData: data })
      },
      fail: function (res) {
        // fail
      }
    })
  },
  //加载商品图
  loadGoods: function () {
    var page = this;
    var goodsrData = [];
    wx.request({
      url: config.service.host + '/Production_interface/index',
      success: function (res) {
        var data = res.data;
        page.setData({ goodsData: data })
      },
      fail: function (res) {
        // fail
      }
    })
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})