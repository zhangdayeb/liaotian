export default {
	state:{
		KeyboardHeight:0,
		moveX:0,
		moveY:0,
	},
	mutations:{
		changeKeyboardHeight(state,h){
			state.KeyboardHeight = h
		},
		setMoveX(x){
			this.moveX = x;
		},
		setMoveY(y){
			this.moveY = y;
		},
	}
}