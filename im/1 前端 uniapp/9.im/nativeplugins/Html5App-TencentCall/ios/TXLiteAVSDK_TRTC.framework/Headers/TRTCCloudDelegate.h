/*
 * Module:   TRTCCloudDelegate @ TXLiteAVSDK
 * 
 * Function: 腾讯云视频通话功能的事件回调接口
 *
 */

#import <Foundation/Foundation.h>
#import "TRTCCloudDef.h"
#import "TXLiteAVCode.h"

NS_ASSUME_NONNULL_BEGIN

@class TRTCCloud;
@class TRTCStatistics;


/**
 * 腾讯云视频通话功能的事件回调接口
 */
@protocol TRTCCloudDelegate <NSObject>
@optional

/////////////////////////////////////////////////////////////////////////////////
//
//                      （一）通用事件回调
//
/////////////////////////////////////////////////////////////////////////////////
/// @name 通用事件回调
/// @{
/**
 * 1.1 错误回调：SDK 不可恢复的错误，一定要监听，并分情况给用户适当的界面提示。
 *
 * @param errCode 错误码
 * @param errMsg  错误信息
 * @param extInfo 扩展信息字段，个别错误码可能会带额外的信息帮助定位问题
 */
- (void)onError:(TXLiteAVError)errCode errMsg:(nullable NSString *)errMsg extInfo:(nullable NSDictionary*)extInfo;

/**
 * 1.2 警告回调：用于告知您一些非严重性问题，比如出现了卡顿或者可恢复的解码失败。
 *
 * @param warningCode 警告码
 * @param warningMsg 警告信息
 * @param extInfo 扩展信息字段，个别警告码可能会带额外的信息帮助定位问题
 */
- (void)onWarning:(TXLiteAVWarning)warningCode warningMsg:(nullable NSString *)warningMsg extInfo:(nullable NSDictionary*)extInfo;

/// @}

/////////////////////////////////////////////////////////////////////////////////
//
//                      （二）房间事件回调
//
/////////////////////////////////////////////////////////////////////////////////
/// @name 房间事件回调
/// @{
/**
 * 2.1 加入房间的事件回调
 *
 * @param elapsed 加入房间耗时
 */
- (void)onEnterRoom:(NSInteger)elapsed;

/**
 * 2.2 离开房间的事件回调
 *
 * @param reason 离开房间原因
 */
- (void)onExitRoom:(NSInteger)reason;


/**
 * 2.3 请求跨房通话的结果回调
 */
- (void)onConnectOtherRoom:(NSString*)userId errCode:(TXLiteAVError)errCode errMsg:(nullable NSString *)errMsg;


/**
 * 2.4 断开跨房通话的结果回调
 */
- (void)onDisconnectOtherRoom:(TXLiteAVError)errCode errMsg:(nullable NSString *)errMsg;
/// @}

/////////////////////////////////////////////////////////////////////////////////
//
//                      （三）成员事件回调
//
/////////////////////////////////////////////////////////////////////////////////
/// @name 成员事件回调
/// @{
/**
 * 3.1 有新的音视频用户加入房间
 *
 * 当有新的音视频用户（有开启音频或者视频上行的用户）加入房间后，房间里的其他用户会收到该通知。
 * 
 * 由于单个 TRTC 的房间可以容纳很多人的加入，所以并不是任何用户加入房间后都会出发 onUserEnter 事件，这可能会造成性能上的灾难。
 * 只有一个用户开启了音频或者视频上行的时候，房间里的其他用户才能收到该通知。
 *
 * 您可以在收到该通知后，在 UI 界面上增加一个用户的头像，但并不推荐立刻 startRemoteView，
 * 因为该用户可能只有声音没有视频，onUserVideoAvailable 则是真正的宣告某个用户的画面可以显示了。
 *
 * @param userId 用户标识
 * @warning - 并不是所有用户加入房间都会触发此通知，只有开启音频或者视频上行的用户才会触发此通知。
 *          - 收到该通知后，并不推荐立刻 startRemoteView，因为可能该用户只开启了音频而没有开启视频。
 */
- (void)onUserEnter:(NSString *)userId;

/**
 * 3.2 有用户从当前房间中离开
 *
 * @param userId 用户标识
 * @param reason 离开原因代码，区分用户是正常离开，还是由于网络断线等原因离开。
 */
- (void)onUserExit:(NSString *)userId reason:(NSInteger)reason; 

/**
 * 3.3 userId 对应的远端主路（即摄像头）画面的状态通知
 *
 * 当 available 为 YES 时，您可以在这个回调中调用 startRemoteView 显示该 userId 的视频画面。
 *
 * @param userId 用户标识
 * @param available 画面是否开启
 */
- (void)onUserVideoAvailable:(NSString *)userId available:(BOOL)available;

/**
 * 3.4 userId 对应的远端辅路（屏幕分享等）画面的状态通知
 * 
 * @note 显示辅路画面使用的函数不是 startRemoteView 而是 startRemoteSubStreamView。
 * @param userId 用户标识
 * @param available 屏幕分享是否开启
 */
- (void)onUserSubStreamAvailable:(NSString *)userId available:(BOOL)available;

/**
 * 3.5 userId 对应的远端声音的状态通知
 *
 * @param userId 用户标识
 * @param available 声音是否开启
 */
- (void)onUserAudioAvailable:(NSString *)userId available:(BOOL)available;

/**
 * 3.6 用于提示音量大小的回调,包括每个 userId 的音量和远端总音量
 *
 * 您可以通过调用 TRTCCloud 中的 enableAudioVolumeEvaluation 接口来开关这个回调或者设置它的触发间隔。
 * 需要注意的是，调用 enableAudioVolumeEvaluation 开启音量回调后，无论频道内是否有人说话，都会按设置的时间间隔调用这个回调;如果没有人说话，则 userVolumes 为空，totalVolume 为0。
 *
 * @param userVolumes 所有正在说话的房间成员的音量（取值范围0 - 100）。即 userVolumes 内仅包含音量不为0（正在说话）的用户音量信息。其中 userId 为 null  表示 local 的音量，也就是自己的音量。
 * @param totalVolume 所有远端成员的总音量, 取值范围0 - 100
 */
- (void)onUserVoiceVolume:(NSArray<TRTCVolumeInfo *> *)userVolumes totalVolume:(NSInteger)totalVolume;

/// @}

/////////////////////////////////////////////////////////////////////////////////
//
//                      （四）统计和质量回调
//
/////////////////////////////////////////////////////////////////////////////////

/// @name 统计和质量回调
/// @{

/**
 * 4.1 网络质量：该回调每2秒触发一次，统计当前网络的上行和下行质量
 *
 * @note userId == nil 代表自己当前的视频质量
 *
 * @param localQuality 上行网络质量
 * @param remoteQuality 下行网络质量
 */
- (void)onNetworkQuality: (TRTCQualityInfo*)localQuality remoteQuality:(NSArray<TRTCQualityInfo*>*)remoteQuality;

/**
 * 4.2 技术指标统计回调
 *
 * 如果您是熟悉音视频领域相关术语，可以通过这个回调获取 SDK 的所有技术指标。
 * 如果您是首次开发音视频相关项目，可以只关注 onNetworkQuality 回调。
 *
 * @param statistics 统计数据，包括本地和远程的
 * @note 每2秒回调一次
 */
- (void)onStatistics: (TRTCStatistics *)statistics;

/// @}

/////////////////////////////////////////////////////////////////////////////////
//
//                      （五）音视频事件回调
//
/////////////////////////////////////////////////////////////////////////////////

/// @name 音视频事件回调
/// @{
/**
 * 5.1 首帧视频画面已到达，界面此时可以结束 Loading，并开始显示视频画面
 * 
 * @param userId 用户 ID
 * @param width  画面宽度
 * @param height 画面高度
 */ 
- (void)onFirstVideoFrame:(NSString*)userId width:(int)width height:(int)height;

/**
 * 5.2 首帧音频数据已到达
 
 * @param userId 用户 ID
 */
- (void)onFirstAudioFrame:(NSString*)userId;

/// @}

/////////////////////////////////////////////////////////////////////////////////
//
//                      （六）服务器事件回调
//
/////////////////////////////////////////////////////////////////////////////////

/// @name 服务器事件回调
/// @{

/**
 * 6.1 SDK 跟服务器的连接断开
 */
- (void)onConnectionLost;

/**
 * 6.2 SDK 尝试重新连接到服务器
 */
- (void)onTryToReconnect;

/**
 * 6.3 SDK 跟服务器的连接恢复
 */
- (void)onConnectionRecovery;

/// @}

/////////////////////////////////////////////////////////////////////////////////
//
//                      （七）硬件设备事件回调
//
/////////////////////////////////////////////////////////////////////////////////

/// @name 硬件设备事件回调
/// @{

/**
 * 7.1 摄像头准备就绪
 */
- (void)onCameraDidReady;

/**
 * 7.2 麦克风准备就绪
 */
- (void)onMicDidReady;

#if TARGET_OS_IPHONE
/**
 * 7.3 音频路由发生变化（仅 iOS），音频路由即声音由哪里输出（扬声器、听筒）
 *
 * @param route     当前音频路由
 * @param fromRoute 变更前的音频路由
 */
- (void)onAudioRouteChanged:(TRTCAudioRoute)route fromRoute:(TRTCAudioRoute)fromRoute;
#endif


#if !TARGET_OS_IPHONE && TARGET_OS_MAC
/**
 * 7.4 本地设备通断回调
 *
 * @param deviceId 设备 ID
 * @param deviceType 设备类型
 * @param state   0：设备断开；1：设备连接
 */
- (void)onDevice:(NSString *)deviceId type:(TRTCMediaDeviceType)deviceType stateChanged:(NSInteger)state;

#endif

/// @}


/////////////////////////////////////////////////////////////////////////////////
//
//                      （八）自定义消息的接收回调
// 
//
/////////////////////////////////////////////////////////////////////////////////

/// @name 自定义消息的接收回调
/// @{

/**
 * 8.1 收到自定义消息回调
 *
 * 当房间中的某个用户使用 sendCustomCmdMsg 发送自定义消息时，房间中的其它用户可以通过 onRecvCustomCmdMsg 接口接收消息
 *
 * @param userId 用户标识
 * @param cmdID 命令 ID
 * @param seq   消息序号
 * @param message 消息数据
 */
- (void)onRecvCustomCmdMsgUserId:(NSString *)userId cmdID:(NSInteger)cmdID seq:(UInt32)seq message:(NSData *)message;

/**
 * 8.2 自定义消息丢失回调
 *
 * TRTC 所使用的传输通道为 UDP 通道，所以即使设置了 reliable，也做不到100%不丢失，只是丢消息概率极低，能满足常规可靠性要求。
 * 在过去的一段时间内（通常为5s），自定义消息在传输途中丢失的消息数量的统计，SDK 都会通过此回调通知出来。
 *   
 * @note  只有在发送端设置了可靠传输（reliable），接收方才能收到消息的丢失回调
 * @param userId 用户标识
 * @param cmdID 命令 ID
 * @param errCode 错误码
 * @param missed 丢失的消息数量
 */
- (void)onMissCustomCmdMsgUserId:(NSString *)userId cmdID:(NSInteger)cmdID errCode:(NSInteger)errCode missed:(NSInteger)missed;

/**
 * 8.3 收到 SEI 消息的回调
 *
 * 当房间中的某个用户使用 sendSEIMsg 发送数据时，房间中的其它用户可以通过 onRecvSEIMsg 接口接收数据。
 *
 * @param userId   用户标识
 * @param message  数据
 */
- (void)onRecvSEIMsg:(NSString *)userId message:(NSData*)message;

/// @}

/////////////////////////////////////////////////////////////////////////////////
//
//                      （九）CDN 旁路转推回调
//
/////////////////////////////////////////////////////////////////////////////////
/// @name CDN 旁路转推回调
/// @{
	
/**
 * 9.1 启动旁路推流到 CDN 完成的回调
 *
 * 对应于 TRTCCloud 中的 startPublishCDNStream() 接口
 *
 * @note Start 回调如果成功，只能说明转推请求已经成功告知给腾讯云，如果目标 CDN 有异常，还是有可能会转推失败。
 */	
- (void)onStartPublishCDNStream:(int)err errMsg:(NSString *)errMsg;

/**
 * 9.2 停止旁路推流到 CDN 完成的回调
 *
 * 对应于 TRTCCloud 中的 stopPublishCDNStream() 接口
 *
 */
- (void)onStopPublishCDNStream:(int)err errMsg:(NSString *)errMsg;

/**
 * 9.3 设置云端的混流转码参数的回调，对应于 TRTCCloud 中的 setMixTranscodingConfig() 接口
 *
 * @param err 0表示成功，其余值表示失败
 * @param errMsg 具体错误原因
 */
- (void)onSetMixTranscodingConfig:(int)err errMsg:(NSString*)errMsg;


/// @}

/////////////////////////////////////////////////////////////////////////////////
//
//                      （十）屏幕分享回调
//
/////////////////////////////////////////////////////////////////////////////////

/// @name 自定义消息的接收回调
/// @{
/**
 * 10.1 当屏幕分享开始时，SDK 会通过此回调通知
 */
- (void)onScreenCaptureStarted;

/**
 * 10.2 当屏幕分享暂停时，SDK 会通过此回调通知
 *
 * @param reason 原因，0：用户主动暂停；1：屏幕窗口不可见暂停
 */
- (void)onScreenCapturePaused:(int)reason;

/**
 * 10.3 当屏幕分享开始时，SDK 会通过此回调通知
 *
 * @param reason 恢复原因，0：用户主动恢复；1：屏幕窗口恢复可见导致恢复分享
 */
- (void)onScreenCaptureResumed:(int)reason;

/**
 * 10.4 当屏幕分享开始时，SDK 会通过此回调通知
 *
 * @param reason 停止原因，0：用户主动停止；1：屏幕窗口关闭导致停止
 */
- (void)onScreenCaptureStoped:(int)reason;
@end
/// @}

/////////////////////////////////////////////////////////////////////////////////
//
//                      （十一）自定义视频渲染回调
//
/////////////////////////////////////////////////////////////////////////////////
#pragma mark - TRTCVideoRenderDelegate

/**
 * 视频数据帧的自定义处理回调
 */
@protocol TRTCVideoRenderDelegate <NSObject>
/**
 * 自定义视频渲染回调
 *
 * @param frame  待渲染的视频帧信息
 * @param userId 视频源的 userId，如果是本地视频回调（setLocalVideoRenderDelegate），该参数可以不用理会
 * @param streamType 视频源类型，比如是摄像头画面还是屏幕分享画面等等
 */
@optional
- (void) onRenderVideoFrame:(TRTCVideoFrame * _Nonnull)frame userId:(NSString* __nullable)userId streamType:(TRTCVideoStreamType)streamType;

@end

/////////////////////////////////////////////////////////////////////////////////
//
//                      （十二）音频数据回调
//
/////////////////////////////////////////////////////////////////////////////////
/**
 * 声音数据帧的自定义处理回调（只读）
 */
@protocol TRTCAudioFrameDelegate <NSObject>
@optional
/**
 * 本地麦克风采集到的音频数据回调
 *
 * @note - 请不要在此回调函数中做任何耗时操作，建议直接拷贝到另一线程进行处理，否则会导致各种声音问题。
 * @note - 此接口回调出的音频数据是只读的，不支持修改。
 */
- (void) onCapturedAudioFrame:(TRTCAudioFrame *)frame;

/**
 * 混音前的每一路远程用户的音频数据（比如您要对某一路的语音进行文字转换，必须要使用这里的原始数据，而不是混音之后的数据）
 *
 * @param frame      音频数据
 * @param userId     用户标识
 * @note - 请不要在此回调函数中做任何耗时操作，建议直接拷贝到另一线程进行处理，否则会导致各种声音问题。
 * @note - 此接口回调出的音频数据是只读的，不支持修改。
 */
- (void) onPlayAudioFrame:(TRTCAudioFrame *)frame userId:(NSString *)userId;

/**
 * 各路音频数据混合后送入喇叭播放的音频数据
 *
 * @note - 请不要在此回调函数中做任何耗时操作，建议直接拷贝到另一线程进行处理，否则会导致各种声音问题。
 * @note - 此接口回调出的音频数据是只读的，不支持修改。
 */
- (void) onMixedPlayAudioFrame:(TRTCAudioFrame *)frame;

@end

/////////////////////////////////////////////////////////////////////////////////
//
//                      （十三）Log 信息回调
//
/////////////////////////////////////////////////////////////////////////////////

/**
 * 日志相关回调
 *
 * 建议在一个比较早初始化的类中设置回调委托对象，如 AppDelegate
 */
@protocol TRTCLogDelegate <NSObject>
/**
 * 有日志打印时的回调
 *
 * @param log 日志内容
 * @param level 日志等级 参见 TRTCLogLevel
 * @param module 值暂无具体意义，目前为固定值 TXLiteAVSDK
 */
@optional
-(void) onLog:(nullable NSString*)log LogLevel:(TRTCLogLevel)level WhichModule:(nullable NSString*)module;

@end


NS_ASSUME_NONNULL_END
