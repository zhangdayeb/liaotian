import _action from './_action';

export default {
	/** tabBar路由钩子 */
	routeTabBarHook(){
		_action.routeTool();
		_action.setStatusTips();
	},
	/** 除了tabBar页面的路由钩子 */
	routeSonHook(){
		_action.routeTool();
	},
}