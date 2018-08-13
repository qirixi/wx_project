// page/component/orders/orders.js
var config = require('../../../config')
var app = getApp()

Page({
  data: {
    address: {},
    hasAddress: false,
    total: 0,
    orders: []
  },
  /**
    * 生命周期函数--监听页面加载
    */
  onLoad: function (options) {
    var cur_cart = [];
    cur_cart = wx.getStorageSync('cart') == '' ? [] : wx.getStorageSync('cart');
    this.setData({
      orders: cur_cart
    });

    var page = this;
    wx.request({
      url: config.service.host + '/User_interface/get_user_address',
      data: { open_id: app.globalData.userInfo.data.openId },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        if (res.data.length > 0) {
          page.setData({
            address : res.data[0],
            hasAddress: true
          })
        }

      },
      fail: function (res) {
        // fail
      }
    })
  },
  onReady() {
    this.getTotalPrice();
  },

  onShow: function () {
    
  },

  /**
   * 计算总价
   */
  getTotalPrice() {
    let orders = this.data.orders;
    let total = 0;
    for (let i = 0; i < orders.length; i++) {
      total += orders[i].num * orders[i].price;
    }
    this.setData({
      total: total
    })
  },

  toPay() {
    wx.showModal({
      title: '提示',
      content: '本系统只做演示，支付系统已屏蔽',
      complete() {
        wx.switchTab({
          url: '/page/component/user/user'
        })
      }
    })
  }
})