Shadowrocket Subscribe Demo
===============

## 简介

此项目是一个简单的 `Shadowrocket` 的订阅服务端演示程序，通过 [FreeSS](https://freess.cx/) 提供的免费 `Shadowsocks` 节点来演示 `Shadowrocket` 的 `Subscribe` 功能

## 服务端部署

项目代码使用 `PHP` 开发，把代码放到能够通过公网访问到的 `PHP` 服务器上运行即可

## Shadowrocket 客户端配置

假设服务器部署完毕后得到一个订阅地址 `http://subscribe.baidu.net/freess/`

首先启动 `Shadowrocket` 客户端

然后点击右上角的 `+` 加号添加节点，类型选择 `Subscribe`，URL 填写你自己的订阅地址 `http://subscribe.baidu.net/freess/`，完成

最后配置一下 `Subscribe` 的更新策略，`设置 - 服务器订阅` 把 `打开时更新` 打开