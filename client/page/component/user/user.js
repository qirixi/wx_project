// page/component/new-pages/user/user.js
var app = getApp()
Page({
  data: {
    thumb: '',
    nickname: '',
    orders: [],
    hasAddress: false,
    address: {}
  },
  onLoad() {
    var self = this;
    if(!app.globalData.userInfo){
      /**
           * 获取用户信息
           */
      wx.getUserInfo({
        success: function (res) {
          self.setData({
            thumb: res.userInfo.avatarUrl,
            nickname: res.userInfo.nickName
          })
        }
      })
    }
    else{
      self.setData({
        thumb: app.globalData.userInfo.data.avatarUrl,
        nickname: app.globalData.userInfo.data.nickName
      })
    }
  
      /**
       * 发起请求获取订单列表信息
       */
     
  },
  onShow() {
    var self = this;
    /**
     * 获取本地缓存 地址信息
     */
    wx.getStorage({
      key: 'address',
      success: function (res) {
        self.setData({
          hasAddress: true,
          address: res.data
        })
      }
    })
  },
  /**
   * 发起支付请求
   */
  payOrders() {
    wx.requestPayment({
      timeStamp: 'String1',
      nonceStr: 'String2',
      package: 'String3',
      signType: 'MD5',
      paySign: 'String4',
      success: function (res) {
        console.log(res)
      },
      fail: function (res) {
        wx.showModal({
          title: '支付提示',
          content: '<text>',
          showCancel: false
        })
      }
    })
  }
})