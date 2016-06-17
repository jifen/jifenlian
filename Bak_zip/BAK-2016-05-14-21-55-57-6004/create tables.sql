-- 表的结构: nnld_access --
CREATE TABLE `nnld_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `pid` smallint(6) NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_address --
CREATE TABLE `nnld_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `moren` int(11) NOT NULL COMMENT '是否为默认地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_benqi --
CREATE TABLE `nnld_benqi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `cpzj` decimal(12,2) NOT NULL,
  `money` decimal(12,2) NOT NULL,
  `adt` int(11) NOT NULL,
  `is_re_nums` int(11) NOT NULL,
  `is_benqi` int(11) NOT NULL,
  `is_yeji` int(11) NOT NULL,
  `is_team_yj` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_bonus --
CREATE TABLE `nnld_bonus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `user_id` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `did` int(11) NOT NULL,
  `s_date` int(11) NOT NULL,
  `e_date` int(11) NOT NULL,
  `b0` decimal(12,2) NOT NULL,
  `b1` decimal(12,2) NOT NULL,
  `b2` decimal(12,2) NOT NULL,
  `b3` decimal(12,2) NOT NULL,
  `b4` decimal(12,2) NOT NULL,
  `b5` decimal(12,2) NOT NULL,
  `b6` decimal(12,2) NOT NULL,
  `b7` decimal(12,2) NOT NULL,
  `b8` decimal(12,2) NOT NULL,
  `b9` decimal(12,2) NOT NULL,
  `b11` decimal(12,2) NOT NULL,
  `b12` decimal(12,2) NOT NULL,
  `b10` decimal(12,2) NOT NULL,
  `encash_l` int(11) NOT NULL,
  `encash_r` int(11) NOT NULL,
  `encash` int(11) NOT NULL,
  `is_count_b` int(11) NOT NULL,
  `is_count_c` int(11) NOT NULL,
  `is_pay` int(11) NOT NULL,
  `u_level` int(11) NOT NULL,
  `type` smallint(2) NOT NULL DEFAULT '0',
  `additional` varchar(50) NOT NULL COMMENT '额外奖',
  `encourage` varchar(50) NOT NULL COMMENT '阶段鼓励奖',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_card --
CREATE TABLE `nnld_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL DEFAULT '0',
  `buser_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_no` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `card_pw` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `c_time` int(11) NOT NULL DEFAULT '0',
  `f_time` int(11) NOT NULL DEFAULT '0',
  `l_time` int(11) NOT NULL DEFAULT '0',
  `b_time` int(11) NOT NULL DEFAULT '0',
  `is_sell` int(3) NOT NULL DEFAULT '0',
  `is_use` int(3) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `money` decimal(12,2) NOT NULL,
  `days` int(11) NOT NULL COMMENT '有效期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_cash --
CREATE TABLE `nnld_cash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `user_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bid` int(11) NOT NULL DEFAULT '0',
  `b_user_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `rdt` int(11) NOT NULL,
  `money` decimal(12,2) NOT NULL,
  `money_two` decimal(12,2) NOT NULL,
  `epoint` int(11) NOT NULL DEFAULT '0',
  `is_pay` int(11) NOT NULL,
  `user_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bank_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bank_card` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `x1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `x2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `x3` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `x4` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sellbz` text COLLATE utf8_unicode_ci NOT NULL,
  `s_type` smallint(3) NOT NULL DEFAULT '0',
  `is_buy` int(11) NOT NULL DEFAULT '0',
  `bdt` int(11) NOT NULL DEFAULT '0',
  `ldt` int(11) NOT NULL DEFAULT '0',
  `okdt` int(11) NOT NULL DEFAULT '0',
  `bz` text COLLATE utf8_unicode_ci NOT NULL,
  `is_sh` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_change_tree --
CREATE TABLE `nnld_change_tree` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL,
  `user_id` varchar(32) NOT NULL DEFAULT '',
  `old_re_id` int(11) unsigned NOT NULL,
  `old_re_name` varchar(32) NOT NULL DEFAULT '',
  `new_re_id` int(11) unsigned NOT NULL,
  `new_re_name` varchar(32) NOT NULL DEFAULT '',
  `pdt` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_chongzhi --
CREATE TABLE `nnld_chongzhi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `user_id` varchar(50) COLLATE utf8_bin NOT NULL,
  `epoint` decimal(12,2) NOT NULL,
  `huikuan` decimal(12,2) NOT NULL,
  `zhuanghao` varchar(32) COLLATE utf8_bin NOT NULL,
  `rdt` int(11) NOT NULL,
  `pdt` int(11) NOT NULL DEFAULT '0',
  `is_pay` smallint(2) NOT NULL,
  `stype` int(11) NOT NULL DEFAULT '0',
  `on_line` int(3) NOT NULL DEFAULT '0',
  `shuoming` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- <fen> --
-- 表的结构: nnld_cody --
CREATE TABLE `nnld_cody` (
  `c_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `cody_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_cptype --
CREATE TABLE `nnld_cptype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tpname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `b_id` int(11) NOT NULL DEFAULT '0',
  `s_id` int(11) NOT NULL DEFAULT '0',
  `t_pai` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_fahuo --
CREATE TABLE `nnld_fahuo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `shuliang` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `is_ok` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `adt` int(11) NOT NULL,
  `pdt` int(11) NOT NULL,
  `user_tel` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_fck --
CREATE TABLE `nnld_fck` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_bz` varchar(64) NOT NULL,
  `account` varchar(64) DEFAULT NULL,
  `bind_account` varchar(50) DEFAULT NULL,
  `new_login_time` int(11) NOT NULL DEFAULT '0',
  `new_login_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_login_time` int(11) unsigned DEFAULT '0',
  `last_login_ip` varchar(40) DEFAULT NULL,
  `login_count` mediumint(8) unsigned DEFAULT '0',
  `verify` varchar(32) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `type_id` tinyint(2) unsigned DEFAULT '0',
  `info` text,
  `name` varchar(25) DEFAULT NULL,
  `dept_id` smallint(3) DEFAULT NULL,
  `user_id` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '用户编号',
  `user_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '银行开户名',
  `password` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '一级密码',
  `pwd1` varchar(50) DEFAULT NULL COMMENT '一级密码不加密',
  `passopen` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '二级密码',
  `pwd2` varchar(50) DEFAULT NULL COMMENT '二级密码不加密',
  `passopentwo` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '三级密码',
  `pwd3` varchar(50) DEFAULT NULL COMMENT '三级密码不加密',
  `nickname` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '昵称',
  `qq` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'QQ',
  `bank_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '开户银行',
  `bank_card` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '银行卡号',
  `bank_province` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '开户银行所在省',
  `bank_city` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '开户银行所在城市',
  `bank_address` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '支行地址',
  `user_code` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '身份证',
  `user_address` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '联系地址',
  `province` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `user_post` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '联系方式',
  `user_tel` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '电话',
  `user_phone` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '手机',
  `rdt` int(11) NOT NULL COMMENT '注册时间',
  `treeplace` int(11) DEFAULT NULL COMMENT '区分左(中)右',
  `father_id` int(11) NOT NULL COMMENT '父节点',
  `father_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '父名',
  `re_id` int(11) NOT NULL COMMENT '推荐ID',
  `re_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '推荐人名称',
  `is_pay` int(11) NOT NULL COMMENT '是否开通(0,1)',
  `is_jiesuan` int(11) NOT NULL,
  `is_lock` int(11) NOT NULL COMMENT '是否锁定(0,1)',
  `is_lock_ok` int(3) NOT NULL DEFAULT '0',
  `shoplx` int(11) NOT NULL COMMENT '报单中心ID',
  `shop_a` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '//中心所在省',
  `shop_b` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '//中心所在县',
  `shop_c` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '//中心所在县',
  `open_type` int(1) unsigned NOT NULL,
  `is_tx` int(1) unsigned NOT NULL,
  `is_agent` int(11) NOT NULL COMMENT '报单中心(0,1,2)',
  `agent_max` decimal(12,2) NOT NULL COMMENT '申请报单总金额',
  `agent_use` decimal(12,2) NOT NULL COMMENT '奖金币',
  `agent_cash` decimal(12,2) NOT NULL COMMENT '报单币',
  `agent_kt` decimal(12,2) NOT NULL DEFAULT '0.00',
  `agent_xf` decimal(12,2) NOT NULL DEFAULT '0.00',
  `agent_cf` decimal(12,2) NOT NULL DEFAULT '0.00',
  `agent_gp` decimal(12,2) NOT NULL DEFAULT '0.00',
  `agent_gc` decimal(12,2) NOT NULL DEFAULT '0.00',
  `gp_num` int(11) NOT NULL DEFAULT '0',
  `tx_num` int(3) NOT NULL DEFAULT '0',
  `lssq` decimal(12,2) NOT NULL,
  `zsq` decimal(12,2) NOT NULL,
  `adt` int(11) NOT NULL COMMENT '申请成报单中心时间',
  `l` int(11) NOT NULL COMMENT '左边总人数',
  `r` int(11) NOT NULL COMMENT '右边总人数',
  `benqi_l` int(11) NOT NULL COMMENT '本期左区新增',
  `benqi_r` int(11) NOT NULL COMMENT '本期右区新增',
  `shangqi_l` int(11) NOT NULL COMMENT '上期左区剩余',
  `shangqi_r` int(11) NOT NULL COMMENT '上期右区剩余',
  `peng_num` int(11) NOT NULL DEFAULT '0',
  `u_level` int(11) NOT NULL COMMENT '等级(会员级别)',
  `is_boss` int(11) NOT NULL COMMENT '管理人为1,其它为0',
  `idt` int(11) NOT NULL,
  `pdt` int(11) NOT NULL COMMENT '开通时间',
  `re_level` int(11) NOT NULL COMMENT '相对于推的代数',
  `p_level` int(11) NOT NULL COMMENT '绝对层数',
  `re_path` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '推荐的路径',
  `p_path` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '自已的路径',
  `tp_path` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_del` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL COMMENT '隶属报单ID',
  `shop_name` varchar(50) NOT NULL,
  `b0` decimal(12,2) NOT NULL COMMENT '每期总资金',
  `b1` decimal(12,2) NOT NULL COMMENT '奖1',
  `b2` decimal(12,2) NOT NULL COMMENT '奖2',
  `b3` decimal(12,2) NOT NULL COMMENT '奖3',
  `b4` decimal(12,2) NOT NULL COMMENT '奖4',
  `b5` decimal(12,2) NOT NULL COMMENT '奖5',
  `b6` decimal(12,2) NOT NULL COMMENT '奖6',
  `b7` decimal(12,2) NOT NULL COMMENT '奖7',
  `b8` decimal(12,2) NOT NULL COMMENT '奖8',
  `b9` decimal(12,2) NOT NULL COMMENT '奖9',
  `b12` decimal(12,2) NOT NULL COMMENT '奖12',
  `b11` decimal(12,2) NOT NULL COMMENT '奖11',
  `b10` decimal(12,2) NOT NULL COMMENT '奖10',
  `wlf` int(11) NOT NULL COMMENT '网络费',
  `cpzj` decimal(12,2) NOT NULL COMMENT '注册金额',
  `cpzj_pv` int(11) NOT NULL,
  `cpzj_level` int(11) NOT NULL,
  `cpzj_pay` decimal(12,2) unsigned NOT NULL COMMENT '已给注册金额',
  `zjj` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '总奖金',
  `re_money` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '推荐总注册金额',
  `cz_epoint` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '冲值总金额',
  `lr` int(11) NOT NULL COMMENT '中间总单数',
  `shangqi_lr` int(11) NOT NULL COMMENT '中间上期剩余单数',
  `benqi_lr` int(11) NOT NULL COMMENT '中间本期单数',
  `user_type` varchar(200) NOT NULL COMMENT '多线登录限制',
  `re_peat_money` decimal(12,2) NOT NULL COMMENT 'x',
  `re_nums` smallint(4) NOT NULL DEFAULT '0' COMMENT 'x',
  `duipeng` decimal(12,2) NOT NULL,
  `_times` int(11) NOT NULL,
  `fanli` int(11) NOT NULL,
  `fanli_time` int(11) NOT NULL,
  `fanli_num` int(11) NOT NULL,
  `fanli_money` decimal(12,2) NOT NULL DEFAULT '0.00',
  `is_fenh` smallint(2) NOT NULL,
  `open` smallint(2) NOT NULL,
  `f4` int(11) NOT NULL DEFAULT '0',
  `new_agent` smallint(1) NOT NULL DEFAULT '0' COMMENT '//是否新服务中心',
  `day_feng` decimal(12,2) NOT NULL DEFAULT '0.00',
  `get_date` int(11) DEFAULT '0',
  `get_numb` int(11) DEFAULT '0',
  `is_jb` int(11) DEFAULT '0',
  `sq_jb` int(11) DEFAULT '0',
  `jb_sdate` int(11) DEFAULT '0',
  `jb_idate` int(11) DEFAULT '0',
  `man_ceng` int(11) NOT NULL DEFAULT '0' COMMENT '//满层数',
  `prem` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '//权限',
  `wang_j` smallint(1) NOT NULL DEFAULT '0' COMMENT '//结构图',
  `wang_t` smallint(1) NOT NULL DEFAULT '0' COMMENT '//推荐图',
  `get_level` int(11) NOT NULL DEFAULT '0',
  `is_xf` smallint(11) NOT NULL DEFAULT '0',
  `xf_money` decimal(12,2) NOT NULL DEFAULT '0.00',
  `is_zy` int(11) NOT NULL DEFAULT '0',
  `zyi_date` int(11) NOT NULL DEFAULT '0',
  `zyq_date` int(11) NOT NULL DEFAULT '0',
  `mon_get` decimal(12,2) NOT NULL DEFAULT '0.00',
  `xy_money` decimal(12,2) NOT NULL DEFAULT '0.00',
  `xx_money` decimal(12,2) NOT NULL DEFAULT '0.00',
  `down_num` int(11) NOT NULL DEFAULT '0',
  `u_pai` int(11) NOT NULL DEFAULT '0',
  `n_pai` int(11) NOT NULL DEFAULT '0',
  `ok_pay` int(11) NOT NULL DEFAULT '0',
  `wenti` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `wenti_dan` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_tj` int(11) NOT NULL DEFAULT '0',
  `re_f4` int(11) NOT NULL DEFAULT '0',
  `is_aa` int(3) NOT NULL DEFAULT '0',
  `is_bb` int(3) NOT NULL DEFAULT '0',
  `us_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `x_pai` int(11) NOT NULL DEFAULT '0',
  `x_out` int(3) NOT NULL DEFAULT '0',
  `x_num` int(11) NOT NULL DEFAULT '0',
  `is_lockqd` int(11) NOT NULL COMMENT '是否关闭签到',
  `is_lockfh` int(11) NOT NULL COMMENT '是否关闭分红',
  `mypv` decimal(12,2) NOT NULL,
  `td_yj` decimal(12,2) NOT NULL COMMENT '下边会员的业绩',
  `gob` int(11) NOT NULL COMMENT '进入B网的次数',
  `is_up` int(11) NOT NULL,
  `cp_time` int(2) NOT NULL COMMENT '投资时间（月）',
  `dl_rdt` int(11) NOT NULL COMMENT '代理申请时间',
  `dl_pdt` int(11) NOT NULL COMMENT '代理申请通过时间',
  `is_company` int(1) unsigned NOT NULL COMMENT '是否为分公司',
  `company_rdt` int(10) unsigned NOT NULL COMMENT '申请分公司时间',
  `company_pdt` int(10) unsigned NOT NULL COMMENT '确认分公司时间',
  `company_id` int(10) unsigned NOT NULL,
  `company_name` varchar(32) NOT NULL,
  `team_yj` decimal(12,2) unsigned NOT NULL,
  `b_point_num` int(11) unsigned NOT NULL,
  `is_zz` int(1) unsigned NOT NULL,
  `feng_jiandian` decimal(12,2) unsigned NOT NULL,
  `reg_id` int(10) unsigned NOT NULL,
  `open_id` int(11) unsigned NOT NULL,
  `shengji_time` int(11) NOT NULL,
  `shenghou_time` int(11) NOT NULL,
  `is_shengji` int(11) NOT NULL,
  `is_suo` int(11) NOT NULL,
  `b_time` int(11) NOT NULL,
  `get_address` varchar(255) NOT NULL,
  `xiaoshou_time` int(11) NOT NULL,
  `yongjin_time` int(11) NOT NULL,
  `jifen_time` int(11) NOT NULL,
  `dongshi_time` int(11) NOT NULL,
  `fafang_time` int(11) NOT NULL,
  `work_day` int(11) NOT NULL,
  `fafang_cishu` int(11) NOT NULL,
  `yi_cishu` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_cf` (`agent_cf`),
  FULLTEXT KEY `index_p_path` (`p_path`)
) ENGINE=MyISAM AUTO_INCREMENT=11136 DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_fck2 --
CREATE TABLE `nnld_fck2` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL,
  `user_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `father_id` int(11) unsigned NOT NULL,
  `treeplace` int(1) unsigned NOT NULL,
  `p_path` text COLLATE utf8_unicode_ci NOT NULL,
  `p_level` int(11) unsigned NOT NULL,
  `num` int(11) unsigned NOT NULL,
  `l` int(11) unsigned NOT NULL,
  `r` int(11) unsigned NOT NULL,
  `u_level` int(11) NOT NULL,
  `down_num` int(1) NOT NULL,
  `sheng` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `is_time` int(11) NOT NULL,
  `is_suo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `index_p_path` (`p_path`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_fee --
CREATE TABLE `nnld_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `i1` int(12) DEFAULT '0',
  `i2` int(12) DEFAULT '0',
  `i3` int(12) DEFAULT '0',
  `i4` int(12) DEFAULT '0',
  `i5` int(12) DEFAULT '0',
  `i6` int(12) DEFAULT '0',
  `i7` int(12) DEFAULT '0',
  `i8` int(12) DEFAULT '0',
  `i9` int(12) DEFAULT '0',
  `i10` int(12) DEFAULT '0',
  `s1` varchar(200) DEFAULT NULL,
  `s2` varchar(200) DEFAULT NULL,
  `s3` varchar(200) DEFAULT NULL,
  `s4` varchar(200) DEFAULT NULL,
  `s5` varchar(200) DEFAULT NULL,
  `s6` varchar(200) DEFAULT NULL,
  `s7` varchar(200) DEFAULT NULL,
  `s8` varchar(200) DEFAULT NULL,
  `s9` varchar(200) DEFAULT NULL,
  `s10` varchar(200) DEFAULT NULL,
  `s11` varchar(200) DEFAULT NULL,
  `s12` varchar(200) DEFAULT NULL,
  `s13` varchar(200) DEFAULT NULL,
  `s14` varchar(200) DEFAULT NULL,
  `s15` varchar(200) DEFAULT NULL,
  `s16` varchar(200) DEFAULT NULL,
  `s17` varchar(200) DEFAULT NULL,
  `s18` varchar(200) DEFAULT NULL,
  `s19` varchar(200) DEFAULT NULL,
  `s20` varchar(200) DEFAULT NULL,
  `str1` varchar(200) DEFAULT NULL,
  `str2` varchar(200) DEFAULT NULL,
  `str3` varchar(200) DEFAULT NULL,
  `str4` varchar(200) DEFAULT NULL,
  `str5` varchar(200) DEFAULT NULL,
  `str6` varchar(200) DEFAULT NULL,
  `str7` varchar(200) DEFAULT NULL,
  `str8` varchar(200) DEFAULT NULL,
  `str9` varchar(200) DEFAULT NULL,
  `str10` varchar(200) DEFAULT NULL,
  `str11` varchar(200) DEFAULT NULL,
  `str12` varchar(200) DEFAULT NULL,
  `str13` varchar(200) DEFAULT NULL,
  `str14` varchar(200) DEFAULT NULL,
  `str15` varchar(200) DEFAULT NULL,
  `str16` varchar(200) DEFAULT NULL,
  `str17` varchar(200) DEFAULT NULL,
  `str18` varchar(200) DEFAULT NULL,
  `str19` varchar(200) DEFAULT NULL,
  `str20` varchar(200) DEFAULT NULL,
  `str21` varchar(200) DEFAULT NULL,
  `str22` varchar(200) DEFAULT NULL,
  `str23` varchar(200) DEFAULT NULL,
  `str24` varchar(200) DEFAULT NULL,
  `str25` varchar(200) DEFAULT NULL,
  `str26` varchar(200) DEFAULT NULL,
  `str27` varchar(200) DEFAULT NULL,
  `str28` varchar(200) DEFAULT NULL,
  `str29` varchar(200) DEFAULT NULL,
  `str30` varchar(200) DEFAULT NULL,
  `str99` text NOT NULL,
  `us_num` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) DEFAULT NULL COMMENT '清空数据时间截',
  `f_time` int(11) NOT NULL DEFAULT '0',
  `a_money` decimal(12,2) NOT NULL DEFAULT '0.00',
  `b_money` decimal(12,2) NOT NULL DEFAULT '0.00',
  `ff_num` int(11) NOT NULL DEFAULT '0',
  `all_yj` decimal(12,2) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_fehlist --
CREATE TABLE `nnld_fehlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `money` decimal(12,2) NOT NULL,
  `days` int(11) NOT NULL,
  `bankid` int(11) NOT NULL,
  `pdt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_fenhong --
CREATE TABLE `nnld_fenhong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` decimal(12,2) NOT NULL,
  `adt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_form --
CREATE TABLE `nnld_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `baile` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_form_class --
CREATE TABLE `nnld_form_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `baile` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_fuwu --
CREATE TABLE `nnld_fuwu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `cpzj` varchar(255) NOT NULL,
  `cpzj_level` int(11) NOT NULL,
  `money` decimal(12,2) NOT NULL,
  `u_level` int(11) NOT NULL,
  `father_id` int(11) NOT NULL,
  `re_id` int(11) NOT NULL,
  `re_path` varchar(255) NOT NULL,
  `p_path` varchar(255) NOT NULL,
  `pdt` int(11) NOT NULL,
  `is_jiesuan` int(11) NOT NULL,
  `is_re_nums` int(11) NOT NULL,
  `is_benqi` int(11) NOT NULL,
  `is_yeji` int(11) NOT NULL,
  `is_team_yj` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_gouwu --
CREATE TABLE `nnld_gouwu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `did` int(11) NOT NULL,
  `lx` int(11) NOT NULL,
  `ispay` smallint(2) NOT NULL,
  `pdt` int(11) NOT NULL,
  `money` decimal(12,2) NOT NULL,
  `shu` int(11) NOT NULL,
  `cprice` decimal(12,2) NOT NULL,
  `pvzhi` decimal(12,2) NOT NULL,
  `guquan` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `s_type` int(11) NOT NULL DEFAULT '0',
  `user_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `us_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `us_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `us_tel` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `isfh` int(11) NOT NULL DEFAULT '0',
  `fhdt` int(11) NOT NULL DEFAULT '0',
  `okdt` int(11) NOT NULL DEFAULT '0',
  `ccxhbz` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_history --
CREATE TABLE `nnld_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `did` int(11) NOT NULL,
  `user_did` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `action_type` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `pdt` int(11) NOT NULL,
  `epoints` decimal(12,2) NOT NULL,
  `allp` decimal(12,2) NOT NULL,
  `bz` text NOT NULL,
  `type` smallint(1) NOT NULL COMMENT '充值0明细1',
  `act_pdt` int(11) NOT NULL DEFAULT '0',
  `des` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_img --
CREATE TABLE `nnld_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `cid` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `itype` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_jifen --
CREATE TABLE `nnld_jifen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `cpzj` varchar(255) NOT NULL,
  `cpzj_level` int(11) NOT NULL,
  `money` decimal(12,2) NOT NULL,
  `u_level` int(11) NOT NULL,
  `father_id` int(11) NOT NULL,
  `re_id` int(11) NOT NULL,
  `re_path` varchar(255) NOT NULL,
  `p_path` varchar(255) NOT NULL,
  `pdt` int(11) NOT NULL,
  `is_jiesuan` int(11) NOT NULL,
  `is_re_nums` int(11) NOT NULL,
  `is_benqi` int(11) NOT NULL,
  `is_yeji` int(11) NOT NULL,
  `is_team_yj` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11136 DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_msg --
CREATE TABLE `nnld_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_uid` int(11) NOT NULL DEFAULT '0',
  `f_user_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `s_uid` int(11) NOT NULL DEFAULT '0',
  `s_user_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `f_time` int(11) NOT NULL DEFAULT '0',
  `f_del` smallint(3) NOT NULL DEFAULT '0',
  `s_del` smallint(3) NOT NULL DEFAULT '0',
  `f_read` smallint(3) NOT NULL DEFAULT '0',
  `s_read` smallint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_news_a --
CREATE TABLE `nnld_news_a` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `n_title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `n_content` text COLLATE utf8_unicode_ci NOT NULL,
  `n_top` int(11) NOT NULL DEFAULT '0',
  `n_status` tinyint(1) NOT NULL DEFAULT '1',
  `n_create_time` int(11) NOT NULL,
  `n_update_time` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_news_class --
CREATE TABLE `nnld_news_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `type` smallint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_peng --
CREATE TABLE `nnld_peng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(12) NOT NULL,
  `ceng` int(12) NOT NULL,
  `l` int(12) NOT NULL,
  `r` int(12) NOT NULL,
  `l1` int(12) NOT NULL,
  `r1` int(12) NOT NULL,
  `l2` int(12) NOT NULL,
  `r2` int(12) NOT NULL,
  `l3` int(12) NOT NULL,
  `r3` int(11) NOT NULL,
  `l_from_id` int(11) NOT NULL,
  `r_from_id` int(11) NOT NULL,
  `is_peng` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_plan --
CREATE TABLE `nnld_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '奖励计划',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_product --
CREATE TABLE `nnld_product` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `cid` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cptype` int(11) DEFAULT '0',
  `ccname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `xhname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `money` decimal(12,2) DEFAULT '0.00',
  `a_money` decimal(12,2) DEFAULT '0.00',
  `b_money` decimal(12,2) DEFAULT '0.00',
  `create_time` int(11) DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `img` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `yc_cp` int(11) NOT NULL DEFAULT '0',
  `pro_type` int(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_promo --
CREATE TABLE `nnld_promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` decimal(12,2) NOT NULL,
  `money_two` decimal(12,2) NOT NULL,
  `u_level` smallint(3) NOT NULL DEFAULT '0' COMMENT '升级前级别',
  `uid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `up_level` smallint(3) NOT NULL COMMENT '升级后级别',
  `danshu` smallint(2) NOT NULL COMMENT '单数',
  `pdt` int(11) NOT NULL,
  `is_pay` smallint(3) NOT NULL DEFAULT '0',
  `u_bank_name` smallint(2) NOT NULL DEFAULT '0' COMMENT '汇款银行',
  `type` smallint(2) NOT NULL DEFAULT '0' COMMENT '0标示晋级，1标示加单',
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_remit --
CREATE TABLE `nnld_remit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `user_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `b_uid` int(11) NOT NULL DEFAULT '0',
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `kh_money` decimal(12,2) NOT NULL DEFAULT '0.00',
  `or_time` int(11) NOT NULL DEFAULT '0',
  `orderid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `bankid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ok_time` int(11) NOT NULL DEFAULT '0',
  `ok_type` int(11) NOT NULL DEFAULT '0',
  `is_pay` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_shangpin --
CREATE TABLE `nnld_shangpin` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `cid` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cptype` int(11) DEFAULT '0',
  `ccname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `xhname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `money` decimal(12,2) DEFAULT '0.00',
  `a_money` decimal(12,2) DEFAULT '0.00',
  `b_money` decimal(12,2) DEFAULT '0.00',
  `create_time` int(11) DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `img` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `yc_cp` int(11) NOT NULL DEFAULT '0',
  `pro_type` int(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_shouru --
CREATE TABLE `nnld_shouru` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `user_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `in_money` decimal(12,2) NOT NULL DEFAULT '0.00',
  `in_time` int(11) NOT NULL DEFAULT '0',
  `in_bz` text COLLATE utf8_unicode_ci NOT NULL,
  `in_type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_times --
CREATE TABLE `nnld_times` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `benqi` int(11) NOT NULL COMMENT '本期结算日期',
  `shangqi` int(11) NOT NULL COMMENT '上期结算日期',
  `is_count_b` int(11) NOT NULL,
  `is_count_c` int(11) NOT NULL,
  `is_count` int(11) NOT NULL,
  `type` smallint(2) NOT NULL DEFAULT '0' COMMENT '是否已经结算',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_tiqu --
CREATE TABLE `nnld_tiqu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `user_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `rdt` int(11) NOT NULL,
  `money` decimal(12,2) NOT NULL,
  `money_two` decimal(12,2) NOT NULL,
  `epoint` decimal(12,2) NOT NULL,
  `is_pay` int(11) NOT NULL,
  `user_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bank_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bank_card` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `x1` varchar(50) DEFAULT NULL,
  `x2` varchar(50) DEFAULT NULL,
  `x3` varchar(50) DEFAULT NULL,
  `x4` varchar(50) DEFAULT NULL,
  `bank_address` varchar(200) NOT NULL,
  `user_tel` varchar(200) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_uplevel --
CREATE TABLE `nnld_uplevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `get_uid` int(11) NOT NULL,
  `pay_uid` int(11) NOT NULL,
  `total_money` int(11) NOT NULL,
  `before_money` int(11) NOT NULL,
  `money` decimal(12,2) NOT NULL,
  `before_level` int(11) NOT NULL,
  `up_level` int(11) NOT NULL,
  `is_ok` int(11) NOT NULL,
  `adt_time` int(11) NOT NULL,
  `pdt_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_xiaoshou --
CREATE TABLE `nnld_xiaoshou` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `cpzj` varchar(255) NOT NULL,
  `cpzj_level` int(11) NOT NULL,
  `money` decimal(12,2) NOT NULL,
  `u_level` int(11) NOT NULL,
  `father_id` int(11) NOT NULL,
  `re_id` int(11) NOT NULL,
  `re_path` varchar(255) NOT NULL,
  `p_path` varchar(255) NOT NULL,
  `pdt` int(11) NOT NULL,
  `is_jiesuan` int(11) NOT NULL,
  `is_re_nums` int(11) NOT NULL,
  `is_benqi` int(11) NOT NULL,
  `is_yeji` int(11) NOT NULL,
  `is_team_yj` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11136 DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_yeji --
CREATE TABLE `nnld_yeji` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `cpzj` varchar(255) NOT NULL,
  `cpzj_level` int(11) NOT NULL,
  `money` decimal(12,2) NOT NULL,
  `u_level` int(11) NOT NULL,
  `father_id` int(11) NOT NULL,
  `re_id` int(11) NOT NULL,
  `re_path` varchar(255) NOT NULL,
  `p_path` varchar(255) NOT NULL,
  `pdt` int(11) NOT NULL,
  `is_jiesuan` int(11) NOT NULL,
  `is_re_nums` int(11) NOT NULL,
  `is_benqi` int(11) NOT NULL,
  `is_yeji` int(11) NOT NULL,
  `is_team_yj` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11136 DEFAULT CHARSET=utf8;
-- <fen> --
-- 表的结构: nnld_yj --
CREATE TABLE `nnld_yj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `pv` decimal(12,2) NOT NULL,
  `pdt` int(11) NOT NULL,
  `is_fen` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- <fen> --
-- 表的结构: nnld_zhuanj --
CREATE TABLE `nnld_zhuanj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `in_uid` int(11) DEFAULT NULL,
  `out_uid` int(11) DEFAULT NULL,
  `in_userid` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `out_userid` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `epoint` decimal(12,2) DEFAULT NULL,
  `rdt` int(11) DEFAULT NULL,
  `sm` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `is_del` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- <fen> --
