/*
 Navicat MongoDB Data Transfer

 Source Server         : 聊
 Source Server Type    : MongoDB
 Source Server Version : 40406
 Source Host           : 185.135.73.43:27017
 Source Schema         : im

 Target Server Type    : MongoDB
 Target Server Version : 40406
 File Encoding         : 65001

 Date: 10/01/2022 22:40:58
*/


// ----------------------------
// Collection structure for im
// ----------------------------
db.getCollection("im").drop();
db.createCollection("im");

// ----------------------------
// Documents of im
// ----------------------------

// ----------------------------
// Collection structure for txzh_chat
// ----------------------------
db.getCollection("txzh_chat").drop();
db.createCollection("txzh_chat");

// ----------------------------
// Documents of txzh_chat
// ----------------------------
db.getCollection("txzh_chat").insert([ {
    _id: ObjectId("61dc4564ac9b4e6deb383be4"),
    "list_id": "68B5F97A46579CF1087212A656587147",
    "user_id": NumberInt("5880"),
    "content_type": NumberInt("0"),
    "msg_type": NumberInt("0"),
    content: {
        text: "欢迎来到IM工作室.有什么问题可以联系我,不在的时候,请联系QQ"
    },
    time: NumberInt("1641825636")
} ]);

// ----------------------------
// Collection structure for txzh_chat_list
// ----------------------------
db.getCollection("txzh_chat_list").drop();
db.createCollection("txzh_chat_list");

// ----------------------------
// Documents of txzh_chat_list
// ----------------------------
db.getCollection("txzh_chat_list").insert([ {
    _id: ObjectId("61dc4564ac9b4e6deb383bde"),
    "user_id": NumberInt("11"),
    "list_id": "68B5F97A46579CF1087212A656587147",
    "user_ids": "[11,5880]",
    type: NumberInt("0"),
    top: NumberInt("0"),
    "top_time": NumberInt("0"),
    "last_chat_time": NumberInt("1641825636"),
    "no_reader_num": NumberInt("1"),
    ignore: NumberInt("0"),
    status: NumberInt("0"),
    "is_disturb": NumberInt("0")
} ]);
db.getCollection("txzh_chat_list").insert([ {
    _id: ObjectId("61dc4564ac9b4e6deb383bdf"),
    "user_id": NumberInt("5880"),
    "list_id": "68B5F97A46579CF1087212A656587147",
    "user_ids": "[11,5880]",
    type: NumberInt("0"),
    top: NumberInt("0"),
    "top_time": NumberInt("0"),
    "last_chat_time": NumberInt("1641825636"),
    "no_reader_num": NumberInt("1"),
    ignore: NumberInt("0"),
    status: NumberInt("0"),
    "is_disturb": NumberInt("0")
} ]);

// ----------------------------
// Collection structure for txzh_chat_member
// ----------------------------
db.getCollection("txzh_chat_member").drop();
db.createCollection("txzh_chat_member");

// ----------------------------
// Documents of txzh_chat_member
// ----------------------------
db.getCollection("txzh_chat_member").insert([ {
    _id: ObjectId("61dc4564ac9b4e6deb383be0"),
    "list_id": "68B5F97A46579CF1087212A656587147",
    "user_id": NumberInt("11"),
    nickname: "",
    "is_admin": NumberInt("0"),
    "is_msg": NumberInt("0"),
    "is_niming": NumberInt("0"),
    miaoqiang: NumberInt("0"),
    "qiang_time": NumberInt("0"),
    "voice_room_state": NumberInt("0"),
    time: NumberInt("1641825636")
} ]);
db.getCollection("txzh_chat_member").insert([ {
    _id: ObjectId("61dc4564ac9b4e6deb383be1"),
    "list_id": "68B5F97A46579CF1087212A656587147",
    "user_id": NumberInt("5880"),
    nickname: "",
    "is_admin": NumberInt("0"),
    "is_msg": NumberInt("0"),
    "is_niming": NumberInt("0"),
    miaoqiang: NumberInt("0"),
    "qiang_time": NumberInt("0"),
    "voice_room_state": NumberInt("0"),
    time: NumberInt("1641825636")
} ]);

// ----------------------------
// Collection structure for txzh_circle
// ----------------------------
db.getCollection("txzh_circle").drop();
db.createCollection("txzh_circle");

// ----------------------------
// Documents of txzh_circle
// ----------------------------

// ----------------------------
// Collection structure for txzh_find
// ----------------------------
db.getCollection("txzh_find").drop();
db.createCollection("txzh_find");

// ----------------------------
// Documents of txzh_find
// ----------------------------

// ----------------------------
// Collection structure for txzh_friend
// ----------------------------
db.getCollection("txzh_friend").drop();
db.createCollection("txzh_friend");

// ----------------------------
// Documents of txzh_friend
// ----------------------------
db.getCollection("txzh_friend").insert([ {
    _id: ObjectId("61dc4564ac9b4e6deb383be2"),
    "user_id": NumberInt("11"),
    "friend_id": NumberInt("5880"),
    from: NumberInt("4"),
    remarks: "",
    "show_circle_he": NumberInt("0"),
    "show_circle_my": NumberInt("0"),
    time: NumberInt("1641825636")
} ]);
db.getCollection("txzh_friend").insert([ {
    _id: ObjectId("61dc4564ac9b4e6deb383be3"),
    "user_id": NumberInt("5880"),
    "friend_id": NumberInt("11"),
    from: NumberInt("4"),
    remarks: "",
    "show_circle_he": NumberInt("0"),
    "show_circle_my": NumberInt("0"),
    time: NumberInt("1641825636")
} ]);

// ----------------------------
// Collection structure for txzh_friend_apply
// ----------------------------
db.getCollection("txzh_friend_apply").drop();
db.createCollection("txzh_friend_apply");

// ----------------------------
// Documents of txzh_friend_apply
// ----------------------------

// ----------------------------
// Collection structure for txzh_user_state
// ----------------------------
db.getCollection("txzh_user_state").drop();
db.createCollection("txzh_user_state");

// ----------------------------
// Documents of txzh_user_state
// ----------------------------
db.getCollection("txzh_user_state").insert([ {
    _id: ObjectId("61dc4564ac9b4e6deb383bdd"),
    "user_id": NumberInt("11"),
    "reader_circle": NumberInt("0"),
    "reader_circle_ids": [ ],
    photo: NumberInt("1"),
    "circle_img": NumberInt("0")
} ]);
