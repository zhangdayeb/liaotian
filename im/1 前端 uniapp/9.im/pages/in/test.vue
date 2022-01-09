<template>
    <view class="content">
        <jContacts ref="jContacts" :mode="mode" :hashFirst="hashFirst" @confirm="contactsConfirm" @cancel="contactsCancel"></jContacts>

        <button type="default" @tap="show('single')">单选模式</button>
        <button type="default" @tap="show('multi')">多选模式</button>
        <button type="default" @tap="chooseList = []">清除</button>

        <view class="res" v-for="(value, index) in chooseList" :key="index">
            {{value.name}}&nbsp;&nbsp;{{value.phone}}
        </view>

    </view>
</template>

<script>
	import jContacts from "@/components/j-contacts/j-contacts.vue"
	
	export default {
	    components: {
	        jContacts,
	    },
	    data() {
	        return {
	            showMask: false,
	            mode: "single",
	            hashFirst: false,
	            chooseList: [],
	        }
	    },
	    methods: {
	
	        show(mode) {
	            this.showMask = true
	            this.mode = mode
	            this.$refs.jContacts.show()
	        },
	        contactsConfirm(res) {
	            this.chooseList = res
	            console.log("返回结果：", JSON.stringify(this.chooseList))
	        },
	        contactsCancel(){
	
	        },
	
	    },
	}
</script>
   