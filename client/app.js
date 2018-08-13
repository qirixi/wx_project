//app.js
var qcloud = require('./vendor/wafer2-client-sdk/index')
var config = require('./config')
var util = require('./utils/util.js')

App({
    onLaunch: function () {
        qcloud.setLoginUrl(config.service.loginUrl)
        console.log('App Launch')

        var that = this
        if (this.globalData.userInfo) {
          typeof cb == "function" && cb(this.globalData.userInfo)
        } else {
          util.showBusy('正在登录')

          // 调用登录接口
          qcloud.login({
            success(result) {
              if (result) {
                util.showSuccess('登录成功')
                that.globalData.userInfo = result.data;
              } else {
                // 如果不是首次登录，不会返回用户信息，请求用户信息接口获取
                qcloud.request({
                  url: config.service.requestUrl,
                  login: true,
                  success(result) {
                    util.showSuccess('登录成功')
                    that.globalData.userInfo = result.data;
                  },

                  fail(error) {
                    util.showModel('请求失败', error)
                    console.log('request fail', error)
                  }
                })
              }
            },

            fail(error) {
              util.showModel('登录失败', error)
              console.log('登录失败', error)
            }
          })
        }
        
        

    },
    onShow: function () {
      console.log('App Show');
      console.log(this.globalData);
    },
    onHide: function () {
      console.log('App Hide')
    },
    globalData: {
      userInfo: null
    }
})