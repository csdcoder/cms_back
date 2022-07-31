CREATE DATABASE IF NOT EXISTS `cms`
DEFAULT CHARACTER SET utf8;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT 'md5()处理之后的单向密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 插入数据
insert into `admin` values(1,'admin',md5('123456'));
insert into `admin` values(2,'coderwhy',md5('123456'));
