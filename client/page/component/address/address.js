// page/component/new-pages/user/address/address.js
var config = require('../../../config')
var app = getApp()
Page({
  data: {
    post_name : '',
    tel : '',
    address : ''
  },
  onLoad() {
    var page = this;
    wx.request({
      url: config.service.host + '/User_interface/get_user_address',
      data: { open_id: app.globalData.userInfo.data.openId },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        if(res.data.length>0){
          page.setData({
            post_name: res.data[0].name,
            tel: res.data[0].tel,
            address: res.data[0].address
          })
          console.log(res.data[0]);
        }
        
      },
      fail: function (res) {
        // fail
      }
    })
  },
  formSubmit() {
    var self = this;
    if (self.data.post_name && self.data.tel && self.data.address) {
      wx.request({
        url: config.service.host + '/User_interface/add_user_address',
        data: { 
          open_id: app.globalData.userInfo.data.openId,
          post_name: self.data.post_name,
          address: self.data.address,
          phone: self.data.tel
         },
        method: 'POST',
        header: {
          'content-type': 'application/x-www-form-urlencoded'
        },
        success: function (res) {
          wx.navigateBack();
        },
        fail: function (res) {
          // fail
        }
      })
    } else {
      wx.showModal({
        title: '提示',
        content: '请填写完整资料',
        showCancel: false
      })
    }
  },
  bindName(e) {
    this.setData({
      post_name: e.detail.value
    })
  },
  bindPhone(e) {
    this.setData({
      tel: e.detail.value
    })
  },
  bindDetail(e) {
    this.setData({
      address: e.detail.value
    })
  }
})