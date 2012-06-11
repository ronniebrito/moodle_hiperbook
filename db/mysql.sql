# Host: blueeyes.ava.ufsc.br
# Database: avamoodle
# Table: 'prefix_hiperbook'
-- phpMyAdmin SQL Dump
-- version 3.1.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Set 27, 2011 as 04:07 PM
-- Versão do Servidor: 5.0.92
-- Versão do PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Banco de Dados: `avaadteste`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `course` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `numbering` tinyint(4) unsigned NOT NULL default '0',
  `disableprinting` tinyint(2) unsigned NOT NULL default '0',
  `customtitles` tinyint(2) unsigned NOT NULL default '0',
  `timecreated` int(10) unsigned NOT NULL default '0',
  `timemodified` int(10) unsigned NOT NULL default '0',
  `template_main` text,
  `template_hw` text,
  `template_tips` text,
  `template_suggs` text,
  `template_css` text,
  `img_hotwords_top` varchar(255) default NULL,
  `img_tips_top` varchar(255) default NULL,
  `img_suggestions_top` varchar(255) default NULL,
  `img_links_top` varchar(255) default NULL,
  `img_hotwords_icon` varchar(255) default NULL,
  `img_tips_icon` varchar(255) default NULL,
  `img_suggestions_icon` varchar(255) default NULL,
  `img_links_icon` varchar(255) default NULL,
  `opentostudents` int(2) default NULL,
  `img_top_popup` varchar(255) default NULL,
  `img_page_next` varchar(255) default NULL,
  `img_page_prev` varchar(255) default NULL,
  `img_separador_toc` varchar(255) default NULL,
  `img_navpath_active_start` varchar(255) default NULL,
  `img_navpath_active_middle` varchar(255) default NULL,
  `img_navpath_active_end` varchar(255) default NULL,
  `img_navpath_inactive_start` varchar(255) default NULL,
  `img_navpath_inactive_middle` varchar(255) default NULL,
  `img_navpath_inactive_end` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_chapters`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_chapters` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parentchapterid` int(2) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `hidden` tinyint(2) unsigned NOT NULL default '0',
  `timecreated` int(10) unsigned NOT NULL default '0',
  `timemodified` int(10) unsigned NOT NULL default '0',
  `importsrc` varchar(255) NOT NULL default '',
  `bookid` int(11) NOT NULL default '0',
  `idnavigation` int(11) NOT NULL default '1',
  `chapternum` int(10) unsigned default NULL,
  `groupid` int(11) default '0',
  `userid` int(11) default NULL,
  `opentostudents` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6938 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_chapters_exercise`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_chapters_exercise` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `chapterid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_chapters_hotword`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_chapters_hotword` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `chapterid` int(10) unsigned NOT NULL default '0',
  `content` text,
  `title` varchar(255) default NULL,
  `hotwordnum` int(10) unsigned default NULL,
  `idhiperbook` int(11) default NULL,
  `groupid` int(11) default '0',
  `userid` int(11) default NULL,
  `opentostudents` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_chapters_links`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_chapters_links` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `chapterid` int(10) unsigned NOT NULL default '0',
  `targetchapterid` int(10) unsigned default NULL,
  `title` varchar(255) default NULL,
  `tipnum` int(10) unsigned default NULL,
  `popup` tinyint(4) NOT NULL default '0',
  `show_navigation` varchar(4) NOT NULL default '1',
  `idpage` int(11) default '0',
  `idtargetpageid` int(11) default '0',
  `target_navigation_chapter` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_chapters_pages`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_chapters_pages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `chapterid` int(10) unsigned NOT NULL default '0',
  `content` text,
  `pagenum` int(10) unsigned default NULL,
  `hidden` int(10) unsigned default NULL,
  `timecreated` int(10) unsigned default NULL,
  `timemodified` int(10) unsigned default NULL,
  `idhiperbook` int(11) default '0',
  `groupid` int(11) default '0',
  `userid` int(11) default '0',
  `opentostudents` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_chapters_suggestions`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_chapters_suggestions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `chapterid` int(10) unsigned NOT NULL default '0',
  `content` text,
  `title` varchar(255) default NULL,
  `suggestionnum` int(10) unsigned default NULL,
  `idhiperbook` int(11) default NULL,
  `groupid` int(11) default '0',
  `userid` int(11) default '0',
  `opentostudents` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_chapters_tips`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_chapters_tips` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `chapterid` int(10) unsigned NOT NULL default '0',
  `content` text,
  `title` varchar(255) default NULL,
  `tipnum` int(10) unsigned default NULL,
  `idhiperbook` int(11) default NULL,
  `groupid` int(11) default '0',
  `userid` int(11) default '0',
  `opentostudents` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_metadata`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_metadata` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `bookid` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_metadata_annotation`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_metadata_annotation` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `metadata_id` int(10) unsigned NOT NULL,
  `entity` text,
  `annotation_description` text,
  `date` text,
  PRIMARY KEY  (`id`),
  KEY `metadata_annotation_FKIndex1` (`metadata_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_metadata_educational`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_metadata_educational` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `metadata_id` int(10) unsigned NOT NULL default '0',
  `interactivitytype` text,
  `exercise` text,
  `slide` text,
  `problem_statement` text,
  `index_type` text,
  `experiment` text,
  `diagram` text,
  `exam` text,
  `questionnaire` text,
  `narrative_text` text,
  `figure` text,
  `graph` text,
  `lecture` text,
  `simulation` text,
  `table_type` text,
  `self_assesment` text,
  `interactivity_level` text,
  `semanticdensity` text,
  `intendedrole_teacher` text,
  `intendedrole_student` text,
  `intendedrole_author` text,
  `intendedrole_manager` text,
  `context_higher_education` text,
  `context_school` text,
  `context_training` text,
  `context_other` text,
  `typicalagerange` text,
  `difficulty` text,
  `typicallearningtime` text,
  `educational_description` text,
  PRIMARY KEY  (`id`),
  KEY `metadata_educational_FKIndex1` (`metadata_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_metadata_general`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_metadata_general` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `metadata_id` int(10) unsigned NOT NULL,
  `identifier` text,
  `title` text,
  `catalog` text,
  `entry` text,
  `language` text,
  `description` text,
  `keyword` text,
  `coverage` text,
  `structure` text,
  `aggregation_level` text,
  PRIMARY KEY  (`id`),
  KEY `metadata_general_FKIndex1` (`metadata_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_metadata_lifecicle`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_metadata_lifecicle` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `metadata_id` int(10) unsigned NOT NULL,
  `version` text,
  `version_status` text,
  PRIMARY KEY  (`id`),
  KEY `metadata_lifecicle_FKIndex1` (`metadata_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_metadata_lifecicle_contribution`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_metadata_lifecicle_contribution` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `metadata_lifecicle_id` int(10) unsigned NOT NULL,
  `role` text,
  `vcard` text,
  `date` text,
  PRIMARY KEY  (`id`),
  KEY `metadata_lifecicle_contribution_FKIndex1` (`metadata_lifecicle_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_metadata_relation`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_metadata_relation` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `metadata_id` int(10) unsigned NOT NULL default '0',
  `kind` text,
  `identifier` text,
  `relation_description` text,
  `catalog` text,
  `entry` text,
  PRIMARY KEY  (`id`),
  KEY `metadata_relation_FKIndex1` (`metadata_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_metadata_rights`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_metadata_rights` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `metadata_id` int(10) unsigned NOT NULL default '0',
  `costs` text,
  `copyrightandothersrestrictions` text,
  `rights_description` text,
  PRIMARY KEY  (`id`),
  KEY `metadata_rights_FKIndex1` (`metadata_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_navigationpath`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_navigationpath` (
  `id` int(11) NOT NULL auto_increment,
  `bookid` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '0',
  `navpathnum` int(11) NOT NULL default '0',
  `summary` text NOT NULL,
  `groupid` int(11) default '0',
  `userid` int(11) default '0',
  `opentostudents` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_navigation_chapters`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_navigation_chapters` (
  `id` int(11) NOT NULL auto_increment,
  `parentnavchapterid` int(11) NOT NULL default '0',
  `chapternum` int(11) NOT NULL default '0',
  `id_old` int(10) unsigned NOT NULL,
  `chapterid` int(10) unsigned default NULL,
  `navigationid` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_pages_hotwords`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_pages_hotwords` (
  `id` int(11) NOT NULL auto_increment,
  `idpage` int(11) NOT NULL,
  `idhotword` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_pages_suggestions`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_pages_suggestions` (
  `id` int(11) NOT NULL auto_increment,
  `idpage` int(11) NOT NULL,
  `idsuggestion` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdl_hiperbook_pages_tips`
--

CREATE TABLE IF NOT EXISTS `mdl_hiperbook_pages_tips` (
  `id` int(11) NOT NULL auto_increment,
  `idpage` int(11) NOT NULL,
  `idtip` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
