<?php

/** 这里是页面模拟数据 */

return  [

    /** 会话列表数据 */
    'chat_list' => [
        [
			      'group_id' => 1,
            'obj_name' => '幸福',
            'last_msg' => '能和心爱的人一起睡觉，是件幸福的事情；可是，打呼噜怎么办？',
            'photo' => 'https://img-cdn-qiniu.dcloud.net.cn/uniapp/images/shuijiao.jpg?imageView2/3/w/200/h/100/q/90'
        ],
        [
			      'group_id' => 2,
            'obj_name' => '木屋',
            'last_msg' => '想要这样一间小木屋，夏天挫冰吃瓜，冬天围炉取暖。',
            'photo' => 'https://img-cdn-qiniu.dcloud.net.cn/uniapp/images/muwu.jpg?imageView2/3/w/200/h/100/q/90'
        ],
        [
			      'group_id' => 3,
            'obj_name' => 'CBD',
            'last_msg' => '烤炉模式的城，到黄昏，如同打翻的调色盘一般。',
            'photo' => 'https://img-cdn-qiniu.dcloud.net.cn/uniapp/images/cbd.jpg?imageView2/3/w/200/h/100/q/90'
        ],
        [
			      'group_id' => 4,
            'obj_name' => '幸福',
            'last_msg' => '能和心爱的人一起睡觉，是件幸福的事情；可是，打呼噜怎么办？',
            'photo' => 'https://img-cdn-qiniu.dcloud.net.cn/uniapp/images/shuijiao.jpg?imageView2/3/w/200/h/100/q/90'
        ],
        [
			      'group_id' => 5,
            'obj_name' => '木屋',
            'last_msg' => '想要这样一间小木屋，夏天挫冰吃瓜，冬天围炉取暖。',
            'photo' => 'https://img-cdn-qiniu.dcloud.net.cn/uniapp/images/muwu.jpg?imageView2/3/w/200/h/100/q/90'
        ],
        [
			      'group_id' => 6,
            'obj_name' => 'CBD',
            'last_msg' => '烤炉模式的城，到黄昏，如同打翻的调色盘一般。',
            'photo' => 'https://img-cdn-qiniu.dcloud.net.cn/uniapp/images/cbd.jpg?imageView2/3/w/200/h/100/q/90'
        ],
        [
			      'group_id' => 7,
            'obj_name' => '木屋',
            'last_msg' => '想要这样一间小木屋，夏天挫冰吃瓜，冬天围炉取暖。',
            'photo' => 'https://img-cdn-qiniu.dcloud.net.cn/uniapp/images/muwu.jpg?imageView2/3/w/200/h/100/q/90'
        ],
        [
			      'group_id' => 8,
            'obj_name' => 'CBD',
            'last_msg' => '烤炉模式的城，到黄昏，如同打翻的调色盘一般。',
            'photo' => 'https://img-cdn-qiniu.dcloud.net.cn/uniapp/images/cbd.jpg?imageView2/3/w/200/h/100/q/90'
        ]
    ],

    /** 对话内容数据 */
    'chat_data' => [
      [
      	'type' => 'system',
      	'msg' => [
      		'id' => 0,
      		'type' => 'text',
      		'content' => [
      			'text' => '欢迎进入HM-chat聊天室'
      		]
      	]
      ],
      [
      	'type' => 'user',
      	'msg' => [
      		'id' => 1,
      		'type' => 'text',
      		'time' => '12:56',
      		'userinfo' => [
      			'uid' => 0,
      			'username' => '大黑哥',
      			'face' => '/static/img/face.jpg'
      		],
      		'content' => [
      			'text' => '为什么温度会相差那么大？'
      		]
      	]
      ],
      [
      	'type' => 'user',
      	'msg' => [
      		'id' => 2,
      		'type' => 'text',
      		'time' => '12:57',
      		'userinfo' => [
      			'uid' => 1,
      			'username' => '售后客服008',
      			'face' => '/static/img/im/face/face_2.jpg'
      		],
      		'content' => [
      			'text' => '这个是有偏差的，两个温度相差十几二十度是很正常的，如果相差五十度，那即是质量问题了。'
      		]
      	]
      ], [
      	'type' => 'user',
      	'msg' => [
      		'id' => 3,
      		'type' => 'voice',
      		'time' => '12:59',
      		'userinfo' => [
      			'uid' => 1,
      			'username' => '售后客服008',
      			'face' => '/static/img/im/face/face_2.jpg'
      		],
      		'content' => [
      			'url' => '/static/voice/1.mp3',
      			'length' => '00:06'
      		]
      	]
      ], [
      	'type' => 'user',
      	'msg' => [
      		'id' => 4,
      		'type' => 'voice',
      		'time' => '13:05',
      		'userinfo' => [
      			'uid' => 0,
      			'username' => '大黑哥',
      			'face' => '/static/img/face.jpg'
      		],
      		'content' => [
      			'url' => '/static/voice/2.mp3',
      			'length' => '00:06'
      		]
      	]
      ],
      [
      	'type' => 'user',
      	'msg' => [
      		'id' => 5,
      		'type' => 'img',
      		'time' => '13:05',
      		'userinfo' => [
      			'uid' => 0,
      			'username' => '大黑哥',
      			'face' => '/static/img/face.jpg'
      		],
      		'content' => [
      			'url' => '/static/img/p10.jpg',
      			'w' => 200,
      			'h' => 200
      		]
      	]
      ],
      [
      	'type' => 'user',
      	'msg' => [
      		'id' => 6,
      		'type' => 'img',
      		'time' => '12:59',
      		'userinfo' => [
      			'uid' => 1,
      			'username' => '售后客服008',
      			'face' => '/static/img/im/face/face_2.jpg'
      		],
      		'content' => [
      			'url' => '/static/img/q.jpg',
      			'w' => 1920,
      			'h' => 1080
      		]
      	]
      ],
      [
      	'type' => 'system',
      	'msg' => [
      		'id' => 7,
      		'type' => 'text',
      		'content' => [
      			'text' => '欢迎进入HM-chat聊天室'
      		]
      	]
      ],

      [
      	'type' => 'system',
      	'msg' => [
      		'id' => 9,
      		'type' => 'redEnvelope',
      		'content' => [
      			'text' => '售后客服008领取了你的红包'
      		]
      	]
      ],
      [
      	'type' => 'user',
      	'msg' => [
      		'id' => 10,
      		'type' => 'redEnvelope',
      		'time' => '12:56',
      		'userinfo' => [
      			'uid' => 0,
      			'username' => '大黑哥',
      			'face' => '/static/img/face.jpg'
      		],
      		'content' => [
      			'blessing' => '恭喜发财，大吉大利，万事如意',
      			'rid' => 0,
      			'isReceived' => false
      		]
      	]
      ],
      [
      	'type' => 'user',
      	'msg' => [
      		'id' => 11,
      		'type' => 'redEnvelope',
      		'time' => '12:56',
      		'userinfo' => [
      			'uid' => 1,
      			'username' => '售后客服008',
      			'face' => '/static/img/im/face/face_2.jpg'
      		],
      		'content' => [
      			'blessing' => '恭喜发财',
      			'rid' => 1,
      			'isReceived' => false
      		]
      	]
      ],

    ],

    /** 好友列表数据 */
    'friend_list' =>  [
        [
            'letter' => 'A',
            'data' => [
                '阿克苏机场',
                '阿拉山口机场',
                '阿勒泰机场',
                '阿里昆莎机场',
                '安庆天柱山机场',
                '澳门国际机场'
            ]
        ], [
            'letter' => 'B',
            'data' => [
                '保山机场',
                '包头机场',
                '北海福成机场',
                '北京南苑机场',
                '北京首都国际机场'
            ]
        ], [
            'letter' => 'C',
            'data' => [
                '长白山机场',
                '长春龙嘉国际机场',
                '常德桃花源机场',
                '昌都邦达机场',
                '长沙黄花国际机场',
                '长治王村机场',
                '常州奔牛机场',
                '成都双流国际机场',
                '赤峰机场'
            ]
        ], [
            'letter' => 'D',
            'data' => [
                '大理机场',
                '大连周水子国际机场',
                '大庆萨尔图机场',
                '大同东王庄机场',
                '达州河市机场',
                '丹东浪头机场',
                '德宏芒市机场',
                '迪庆香格里拉机场',
                '东营机场',
                '敦煌机场'
            ]
        ], [
            'letter' => 'E',
            'data' => [
                '鄂尔多斯机场',
                '恩施许家坪机场',
                '二连浩特赛乌苏国际机场'
            ]
        ], [
            'letter' => 'F',
            'data' => [
                '阜阳西关机场',
                '福州长乐国际机场'
            ]
        ], [
            'letter' => 'G',
            'data' => [
                '赣州黄金机场',
                '格尔木机场',
                '固原六盘山机场',
                '广元盘龙机场',
                '广州白云国际机场',
                '桂林两江国际机场',
                '贵阳龙洞堡国际机场'
            ]
        ], [
            'letter' => 'H',
            'data' => [
                '哈尔滨太平国际机场',
                '哈密机场',
                '海口美兰国际机场',
                '海拉尔东山国际机场',
                '邯郸机场',
                '汉中机场',
                '杭州萧山国际机场',
                '合肥骆岗国际机场',
                '和田机场',
                '黑河机场',
                '呼和浩特白塔国际机场',
                '淮安涟水机场',
                '黄山屯溪国际机场'
            ]
        ], [
            'letter' => 'I',
            'data' => []
        ], [
            'letter' => 'J',
            'data' => [
                '济南遥墙国际机场',
                '济宁曲阜机场',
                '鸡西兴凯湖机场',
                '佳木斯东郊机场',
                '嘉峪关机场',
                '锦州小岭子机场',
                '景德镇机场',
                '井冈山机场',
                '九江庐山机场',
                '九寨黄龙机场'
            ]
        ], [
            'letter' => 'K',
            'data' => [
                '喀什机场',
                '克拉玛依机场',
                '库车龟兹机场',
                '库尔勒机场',
                '昆明巫家坝国际机场'
            ]
        ], [
            'letter' => 'L',
            'data' => [
                '拉萨贡嘎机场',
                '兰州中川机场',
                '丽江三义机场',
                '黎平机场',
                '连云港白塔埠机场',
                '临沧机场',
                '临沂机场',
                '林芝米林机场',
                '柳州白莲机场',
                '龙岩冠豸山机场',
                '泸州蓝田机场',
                '洛阳北郊机场'
            ]
        ], [
            'letter' => 'M',
            'data' => [
                '满洲里西郊机场',
                '绵阳南郊机场',
                '漠河古莲机场',
                '牡丹江海浪机场'
            ]
        ], [
            'letter' => 'N',
            'data' => [
                '南昌昌北国际机场',
                '南充高坪机场',
                '南京禄口国际机场',
                '南宁吴圩机场',
                '南通兴东机场',
                '南阳姜营机场',
                '宁波栎社国际机场'
            ]
        ], [
            'letter' => 'O',
            'data' => []
        ], [
            'letter' => 'P',
            'data' => [
                '普洱思茅机场'
            ]
        ], [
            'letter' => 'Q',
            'data' => [
                '齐齐哈尔三家子机场',
                '秦皇岛山海关机场',
                '青岛流亭国际机场',
                '衢州机场',
                '泉州晋江机场'
            ]
        ], [
            'letter' => 'R',
            'data' => [
                '日喀则和平机场'
            ]
        ], [
            'letter' => 'S',
            'data' => [
                '三亚凤凰国际机场',
                '汕头外砂机场',
                '上海虹桥国际机场',
                '上海浦东国际机场',
                '深圳宝安国际机场',
                '沈阳桃仙国际机场',
                '石家庄正定国际机场',
                '苏南硕放国际机场'
            ]
        ], [
            'letter' => 'T',
            'data' => [
                '塔城机场',
                '太原武宿国际机场',
                '台州路桥机场 (黄岩机场)',
                '唐山三女河机场',
                '腾冲驼峰机场',
                '天津滨海国际机场',
                '通辽机场',
                '铜仁凤凰机场'
            ]
        ], [
            'letter' => 'U',
            'data' => []
        ], [
            'letter' => 'V',
            'data' => []
        ], [
            'letter' => 'W',
            'data' => [
                '万州五桥机场',
                '潍坊机场',
                '威海大水泊机场',
                '文山普者黑机场',
                '温州永强国际机场',
                '乌海机场',
                '武汉天河国际机场',
                '乌兰浩特机场',
                '乌鲁木齐地窝堡国际机场',
                '武夷山机场',
                '梧州长洲岛机场'
            ]
        ], [
            'letter' => 'X',
            'data' => [
                '西安咸阳国际机场',
                '西昌青山机场',
                '锡林浩特机场',
                '西宁曹家堡机场',
                '西双版纳嘎洒机场',
                '厦门高崎国际机场',
                '香港国际机场',
                '襄阳刘集机场',
                '兴义机场',
                '徐州观音机场'
            ]
        ], [
            'letter' => 'Y',
            'data' => [
                '延安二十里堡机场',
                '盐城机场',
                '延吉朝阳川机场',
                '烟台莱山国际机场',
                '宜宾菜坝机场',
                '宜昌三峡机场',
                '伊春林都机场',
                '伊宁机场',
                '义乌机场',
                '银川河东机场',
                '永州零陵机场',
                '榆林榆阳机场',
                '玉树巴塘机场',
                '运城张孝机场'
            ]
        ], [
            'letter' => 'Z',
            'data' => [
                '湛江机场',
                '昭通机场',
                '郑州新郑国际机场',
                '芷江机场',
                '重庆江北国际机场',
                '中卫香山机场',
                '舟山朱家尖机场',
                '珠海三灶机场'
            ]
        ]
    ],

	/** 朋友圈消息 */
	'circle_data' => [
    [
      'post_id' => '1',
      'uid' => 1,
      'username' => '龙葵',
      'header_image' => '/static/test/header03.jpg',
      'content' => [
      	'text' => '内裤上百条，晒不干一条；衣服晾不干，亲人泪两行',
      	'images' => ['/static/test/test2.jpg']
      ],
      'islike' => 0,
      'like' => [[
      		'uid' => 2,
      		'username' => '小李子,'
      	],
      	[
      		'uid' => 3,
      		'username' => '小张子'
      	]
      ],
      'comments' => [
      	'total' => 2,
      	'comment' => [[
      			'uid' => 2,
      			'username' => '小爱',
      			'content' => '加个微信吧!基金基金基金基金基金基金基金基金基金基金基金基金基金基金基金基金基金基金'
      		],
      		[
      			'uid' => 3,
      			'username' => '小虎',
      			'content' => '一起出去好吗?'
      		]
      	]
      ],
      'timestamp' => '5分钟前'
      ],
      [
      'post_id' => 2,
      'uid' => 1,
      'username' => '菁英公寓-打造属于你的私密空间 小吴',
      'header_image' => '/static/test/header04.jpg',
      'content' => [
      	'text' => '租房:东环朝南\n\r2室大衣柜\n\r燃气热水器\n\r5楼采光充足\n\r随时入住',
      	'images' => [
      		'/static/test/pig-01.jpg',
      		'/static/test/pig-02.jpg',
      		'/static/test/pig-03.jpg',
      		'/static/test/pig-04.jpg',
      		'/static/test/pig-05.jpg',
      		'/static/test/pig-06.jpg',
      		'/static/test/pig-07.jpg',
      		'/static/test/pig-08.jpg',
      		'/static/test/pig-09.jpg'
      	]
      ],
      'islike' => 0,
      'like' => [[
      		'uid' => 2,
      		'username' => '小王子,'
      	],
      	[
      		'uid' => 3,
      		'username' => '张大大'
      	]
      ],
      'comments' => [
      	'total' => 2,
      	'comment' => [[
      			'uid' => 2,
      			'username' => '小虎',
      			'content' => '吃错药了!'
      		],
      		[
      			'uid' => 3,
      			'username' => '小狼',
      			'content' => '霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍!'
      		]
      	]
      ],
      'timestamp' => '1小时前'
      ],
      [
      'post_id' => 2,
      'uid' => 1,
      'username' => 'BSK 必胜客新苏  小乐',
      'header_image' => '/static/test/header05.jpg',
      'content' => [
      	'text' => '美食花样多，诱人如北北；迎来小宇宙，幸福两行泪[喵喵]这可是小必的心声啊～',
      	'images' => ['/static/test/header01.jpg', '/static/test/header01.jpg',
      		'/static/test/header01.jpg', '/static/test/header01.jpg'
      	]
      ],
      'islike' => 0,
      'like' => [[
      		'uid' => 2,
      		'username' => '小王子,'
      	],
      	[
      		'uid' => 3,
      		'username' => '张大大'
      	]
      ],
      'comments' => [
      	'total' => 2,
      	'comment' => [[
      			'uid' => 2,
      			'username' => '小虎',
      			'content' => '吃错药了!'
      		],
      		[
      			'uid' => 3,
      			'username' => '小狼',
      			'content' => '霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍!'
      		]
      	]
      ],
      'timestamp' => '7小时前'
      ]
    ],

];
