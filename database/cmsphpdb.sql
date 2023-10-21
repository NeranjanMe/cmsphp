-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2023 at 02:51 AM
-- Server version: 10.5.20-MariaDB-cll-lve
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onemhmce_cmsphpdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads_placement`
--

CREATE TABLE `ads_placement` (
  `id` int(11) NOT NULL,
  `adsheader` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adsslidebar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adsfooter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adscenter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ads_placement`
--

INSERT INTO `ads_placement` (`id`, `adsheader`, `adsslidebar`, `adsfooter`, `adscenter`) VALUES
(1, '<!-- ADS Header Code -->\r\n<div class=\"ad-header\">\r\n    <a href=\"https://www.example-advertiser.com\" target=\"_blank\">\r\n        <img src=\"https://uptoware.com/uploads/ads/Rectangle6.png\" alt=\"Advertise with Us - Header\">\r\n    </a>\r\n</div>\r\n', '<!-- ADS Slide Bar Code -->\r\n<div class=\"ad-slidebar\">\r\n    <a href=\"https://www.example-advertiser.com/product\" target=\"_blank\">\r\n        <img src=\"https://uptoware.com/uploads/ads/Rectangle7.png\" alt=\"Special Product Offer\">\r\n    </a>\r\n</div>\r\n', '<!-- ADS Footer Code -->\r\n<div class=\"ad-footer\">\r\n    <a href=\"https://www.example-advertiser.com/signup\" target=\"_blank\">\r\n        <img src=\"https://uptoware.com/uploads/ads/Rectangle6.png\" alt=\"Sign Up Now and Get Discounts\">\r\n    </a>\r\n</div>\r\n', '<!-- ADS Center Code -->\r\n<div class=\"ad-center\">\r\n    <a href=\"https://www.example-advertiser.com/event\" target=\"_blank\">\r\n        <img src=\"https://uptoware.com/uploads/ads/Rectangle6.png\" alt=\"Join Our Upcoming Event\">\r\n    </a>\r\n</div>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

CREATE TABLE `api` (
  `id` int(11) NOT NULL,
  `openai` varchar(255) NOT NULL,
  `delle2` varchar(255) NOT NULL,
  `texttovoice` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `api`
--

INSERT INTO `api` (`id`, `openai`, `delle2`, `texttovoice`) VALUES
(1, 'A', 'A', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `is_default`, `image`, `slug`, `description`) VALUES
(33, 'SEO', 0, 'seo.jpg', 'seo', 'Search Engine Land is your source for SEO news and content. Youâ€™ll find a variety of up-to-date and authoritative resources, including the latest news, tactic-rich tutorials, and the latest data to help you work smarter and make better decisions.'),
(34, 'Blog', 1, 'blog.jpeg', 'blog', 'Explore insightful and engaging blog articles on a wide range of topics in our Blog category. Stay informed, entertained, and inspired with our diverse collection of thought-provoking content.'),
(35, 'PPC', 0, 'ppc.jpg', 'ppc', 'Search Engine Land is your source for PPC news and content. Youâ€™ll find a variety of up-to-date and authoritative resources, including the latest news, tactic-rich tutorials, and the latest data to help you work smarter and make better decisions.'),
(36, 'Google', 0, 'google.jpg', 'google', 'Search Engine Land is your source for Google news and content. Youâ€™ll find a variety of up-to-date and authoritative resources, including the latest news, tactic-rich tutorials, and the latest data to help you work smarter and make better decisions.');

-- --------------------------------------------------------

--
-- Table structure for table `headerfooter`
--

CREATE TABLE `headerfooter` (
  `id` int(11) NOT NULL,
  `header` mediumtext DEFAULT NULL,
  `footer` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `headerfooter`
--

INSERT INTO `headerfooter` (`id`, `header`, `footer`) VALUES
(1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `meta_keyword` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `created_at`, `updated_at`, `meta_keyword`, `meta_title`, `meta_description`) VALUES
(2, 'About Us', 'about-us', '<p>The software listed on FileCroco.com is carefully tested and evaluated before publishing. In order to be approved for listing, each products has to meet high quality standards ( usability, performance, etc ) â€“ but, first of all, it has to be useful to users. Therefore, we do not take any automated submissions ( PAD files or else ).</p>', '2023-10-05 17:03:31', '2023-10-05 17:03:31', NULL, NULL, NULL),
(3, 'Privacy Policy', 'privacy-policy', '<p>At FileCroco we consider the privacy of our visitors to be extremely important. This privacy policy document describes in detail the types of personal information is collected and recorded by FileCroco.com and how we use it. No effort is made to identify individuals without their knowledge.</p><p><br></p><p>LOG FILES</p><p>When a user requests pages from FileCroco.com web site, our servers automatically recognize the domain name and the IP address. We collect the domain names, browser types, refferit pages, exit pages, IP addresses in order to aggregate information on the pages users access or visit. This information is collected solely for statistical purposes and is not used to identify individuals. Whenever the identity of a visitor is recorded we will clearly indicate the purpose of the request before the information is requested.</p><p><br></p><p>COOKIES</p><p>A cookie is a piece of data stored on the user hard disk drive containing information about him. Usage of a cookie is in no way linked to any personally identifiable information while on our site. Some of our partners use cookies on our site (for example, Google Adsense). However, we have no access to or control over these cookies. Please refer to the privacy policies of the above mentioned network for details.</p><p><br></p><p>Googleâ€™s use of the DoubleClick cookie enables it and its partners to serve ads to your users based on their visit to our sites and/or other sites on the Internet. Users may opt out of the use of the DoubleClick cookie for interest-based advertising by visiting Ads Settings. Alternatively, users can opt out of a third-party vendorâ€™s use of cookies for interest based advertising by visiting aboutads.info.</p><p><br></p><p>FileCroco.com may also use other advertising networks (other than Google AdSense), whose privacy policies will always be listed on their respective sites. Most of these companies belong to the Network Advertising Initiative. Our visitors may opt-out of behavioral advertising meathods by visiting networkadvertising.org.</p><p><br></p><p>SECURITY</p><p>This web site takes every precaution to protect all our users information. When users submit sensitive information via the web site, your information is protected both online and off-line. Our registration/order form will never asks users to enter sensitive information such as credit card number and/or social security number.</p><p><br></p><p>UNSOLICITED COMMUNICATION</p><p>FileCroco.com will not use your e-mail address in order to send you any kind of unsolicited or promotional mail.</p><p><br></p><p>CONSENT</p><p>By using FileCroco.com, you hereby consent to our privacy policy and agree to its terms.</p><p><br></p><p>UPDATE</p><p>Any changes we may make to our Privacy Policy in the future will be posted on this page.</p><p><br></p><p>Last updated: Saturday, February 16, 2019.</p>', '2023-10-05 17:03:43', '2023-10-05 17:03:43', NULL, NULL, NULL),
(4, 'Terms and conditions', 'terms-and-conditions', '<p>WHEN ACCESSING OR USING ( BROWSING ) THIS WEBSITE, YOU AGREE TO BE BOUND BY THE TERMS AND CONDITIONS DESCRIBED BELOW. IF YOU DO NOT AGREE TO BE BOUND BY THESE TERMS AND CONDITIONS, YOU MAY NOT ACCESS OR USE ( BROWSE ) THE WEB SITE. FileCroco.com IS ALLOWED TO MODIFY THIS AGREEMENT AT ANY TIME AND WITHOUT RPEVIOUS NOTICE AND SUCH MODIFICATIONS SHALL BE EFFECTIVE IMMEDIATELY UPON POSTING OF THE MODIFIED AGREEMENT ON THE WEB SITE. YOU UNDERSTAND AND AGREE TO READ THE AGREEMENT PERIODICALLY IN ORDER TO BE AWARE OF SUCH MODIFICATIONS AND YOUR CONTINUED ACCESS OR USE OF THE WEBSITE SHALL BE DEEMED YOUR CONCLUSIVE ACCEPTANCE OF THE MODIFIED TERMS AND CONDITIONS AGREEMENT.</p><p><br></p><p>USE OF THIS SITE</p><p><br></p><p>You understand that, except for information, products or services clearly identified as being supplied by FileCroco.com, that FileCroco.com does not operate, control or endorse any information, products or services on the Internet in any way. Except for FileCroco.com identified information, products or services, all information, products and services offered through this site or on the Internet generally are offered by third parties that are not affiliated with FileCroco.com.</p><p><br></p><p>Although FileCroco.com has a strict policy of checking all software made available for downloading using latest up-to-date virus scanning technology, you should understand that FileCroco.com cannot and does not guarantee or warrant that all the files available for downloading through the site will be free of infection or Viruses, Worms, Trojan horses or other code that manifest contaminating or destructive properties. You are responsible for implementing enough procedures and checkpoints to satisfy your particular requirements for accuracy of data input and output and for maintaining any means external to the site for the backup and reconstruction of any lost data.</p><p><br></p><p>YOU ASSUME TOTAL RESPONSIBILITY AND RISK FOR YOUR USE OF THE WEB SITE AND THE INTERNET. FileCroco.com PROVIDES THE SITE, RELATED INFORMATION AND SOFTWARE â€“ AS IS â€“ AND DOES NOT MAKE ANY EXPRESS OR IMPLIED WARRANTIES, REPRESENTATIONS OR ENDORSEMENTS WHATSOEVER ( INCLUDING, WITHOUT LIMITATION, WARRANTIES OF TITLE OR NON-INFRINGEMENT, OR THE IMPLIED WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE) WITH REGARD TO THE SERVICE, ANY MERCHANDISE INFORMATION OR SERVICE PROVIDED THROUGH THE SERVICE OR ON THE INTERNET GENERALLY AND FileCroco.com SHALL NOT BE LIABLE FOR ANY COST OR DAMAGE ARISING EITHER DIRECTLY OR INDIRECTLY FROM ANY SUCH TRANSACTION. IT IS SOLELY YOUR RESPONSIBILITY TO EVALUATE THE ACCURACY, COMPLETENESS AND USEFULNESS OF ALL OPINIONS, ADVICE, SERVICES, MERCHANDISE AND OTHER INFORMATION PROVIDED THROUGH THE SERVICE OR ON THE INTERNET GENERALLY. FileCroco.com DOES NOT WARRANT THAT THE SERVICE WILL BE UNINTERRUPTED 100% OR ERROR-FREE OR THAT DEFECTS IN THE SERVICE WILL BE CORRECTED.</p><p><br></p><p>FileCroco.com makes no representations whatsoever about any other web sites which you may access through this web site or which may link to this web site. When you access a web site not owned and maintained by FileCroco.com, please understand that it is independent from FileCroco.com, and that FileCroco.com has no control over the content on that web site. In addition, a link to a web site does not mean that FileCroco.com endorses or accepts any responsibility for the content or the use of such web site.</p><p><br></p><p>Without limiting the foregoing, you agree that you will not use our websites to take any of the following actions:</p><p>1. Defame, stalk, abuse, harass, threaten or otherwise violate the legal right of the others</p><p>2. Publish, post, upload, e-mail, distribute or disseminate any inappropriate, profane, defamatory, infringing, obscene, indecent or unlawful content</p><p>3. Transmit files that contain viruses, malwares, corrupted files or any other similar software that may damage or adversely affect the operation of another computer, our web site, any software, hardware or telecommunications equipment 4. Advertise or offer to sell any products, goods or services for any commercial purpose un</p><p>less you have our written agreement to do so</p><p>5. Transmit surveys, contests, pyramid schemes, spam, unsolicited advertising or promotional materials or chain letters</p><p>6. Download any file that you know or reasonably should know cannot be legally obtained in such way</p><p>7. Falsify or delete any author attributions, legal or other proper notices or proprietary designations or labels of the origin or the source of software or other material</p><p>8. Restrict or inhibit any other user from using and enjoying any public area within our web site</p><p>9. Collect or store personal information about other end users of this web site</p><p>10. Interfere with or disrupt our web site or servers</p><p>11. Forge headers or manipulate identifiers or other data in order to disguise the origin of any content transmitted through our web site or to manipulate your presence on our web site</p><p>12. Engage in any illegal activities of any kind</p><p><br></p><p>INDEMNITY</p><p><br></p><p>You agree to indemnify, defend and hold harmless FileCroco.com, its employees, licensors, suppliers and any third party information providers to the service from and against all losses, expenses, damages and costs, including reasonable attorneys fees, resulting from any violation of this agreement by you or any other person accessing the service.</p>', '2023-10-05 17:03:53', '2023-10-05 17:03:53', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Publish','Draft','Schedule') DEFAULT NULL,
  `permalink` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL DEFAULT 'en',
  `image` varchar(255) DEFAULT NULL,
  `scheduled_date` datetime DEFAULT NULL,
  `mainkeyword` varchar(255) DEFAULT NULL,
  `texttovoice` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `category`, `meta_title`, `meta_description`, `meta_keyword`, `body`, `author`, `created_at`, `updated_at`, `status`, `permalink`, `language`, `image`, `scheduled_date`, `mainkeyword`, `texttovoice`) VALUES
(118, 'SEM career playbook: Overview of a growing industry', 'seo', 'SEM career playbook: Overview of a growing industry', 'SEM career playbook: Overview of a growing industry These are the core titles, roles, tasks and responsibilities for search marketing positions, as you move from junior to senior roles.', 'SEM', '<p>Digital marketing is a great career field. For more than two decades, digital marketing has been a growing field where individuals can thrive and build impressive careers.</p><p>The industry is always changing. But one thing that wonâ€™t change is that companies will continue to need smart people to manage their digital marketing initiatives.&nbsp;</p><p>U.S. digital ad spending will continue to grow over the next five years, according to eMarketer research. By 2025, U.S. digital ad spending should reach approximately $315 billion. The rate of change is predicted to slow over the coming years, but the digital marketing industry should continue to provide a wide array of career opportunities.&nbsp;</p><p>A recent&nbsp;<a href=\"https://www.bls.gov/ooh/management/advertising-promotions-and-marketing-managers.htm\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">study by the Bureau of Labor Statistics</a>&nbsp;shows similar trends. Their report does not mention digital marketing specifically, but that data is included in this general report.</p><p>According to their 2021 data:</p><blockquote>â€œOverall employment of advertising, promotions, and marketing managers is projected to grow 10 percent from 2021 to 2031, faster than the average for all occupations. About 35,300 openings for advertising, promotions, and marketing managers are projected each year, on average, over the decade.â€</blockquote><p>The economy is on shaky ground right now. A recession&nbsp;<a href=\"https://searchengineland.com/tips-strong-media-planning-during-recession-386905\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">seems to be looming</a>, but no one knows exactly what will happen.</p><p>Even if the next 12-18 months are challenging from a macroeconomic viewpoint, the&nbsp;<a href=\"https://searchengineland.com/latest-jobs-in-search-marketing-378959\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">opportunities within the digital marketing industry</a>&nbsp;should continue to thrive.&nbsp;</p><p>Such opportunities can lead you to a small or large agency, an in-house team, your own shop as an individual contractor, and the list goes on. Throughout a career in this field, you will likely find yourself in various roles for a number of organizations.&nbsp;</p><p>The&nbsp;<a href=\"https://searchengineland.com/digital-marketing-career-path-380417\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">career path</a>&nbsp;of someone in search engine marketing (SEM) will likely move from junior to senior roles.</p><p>Letâ€™s explore how many of these roles are structured and how your SEM career might take shape. Your path is unique, but these are guidelines for the industry right now.&nbsp;</p><h2>Entry-level/junior SEM roles</h2><p>Most people will start their career in any field with an entry-level position. The same goes for the digital marketing industry. Many folks will land their first job out of college with a digital agency or in-house with a marketing team.</p><p>Also, individuals move into digital marketing from other departments within an organization as well. For example, moving from product development/management to digital marketing.&nbsp;</p><p>These roles often do not require an extensive amount of experience with digital marketing. Most employers will not expect a great deal of experience but they will be looking for individuals with:</p><ul><li>A drive to excel.</li><li>An aptitude to learn.</li><li>A strong ability to communicate.&nbsp;</li></ul><p>The expected duration in each role will depend on where you work.</p><p>Some employers promote people faster than others. More aggressive progression is positive if you want to move quickly between roles.</p><p>However, if you move too quickly, you will not have time to develop and master the skills that will build toward your next role. On average, individuals will serve in entry-level roles for 12-18 months before being promoted.&nbsp;</p><h3>Tasks and responsibilities</h3><p>The tasks entry/junior level team members complete often focus on supporting more senior members of the team. These duties include:</p><ul><li>Creating reports.</li><li>Conducting QA checks.</li><li>Building SEM campaigns.</li><li>Monitoring account performance.</li><li>Attending training sessions and acquiring certifications.</li><li>Taking meeting notes.</li><li>Other foundational tasks.</li></ul><h3>Titles and roles&nbsp;</h3><p>There are an endless number of potential titles within the SEM field for each step along your digital marketing career journey.&nbsp;</p><p>There is usually a channel signifier within the title, such as:</p><ul><li>Digital</li><li>Search</li><li>Social</li><li>SEO</li><li>Display</li><li>Paid search</li><li>Paid social</li><li>Programmatic&nbsp;</li></ul><p>The second component of titles is the role/seniority. For entry-level roles, you can expect titles like:</p><ul><li>Associate</li><li>Specialist</li><li>Coordinator</li><li>Strategist</li><li>Assistant&nbsp;</li></ul>', 'neranjan', '2023-10-07 18:04:48', '2023-10-07 18:05:53', 'Publish', 'sem-career-playbook-overview-of-a-growing-industry', 'en', 'sem-career-playbook:-overview-of-a-growing-industry-1696701888.jpg', NULL, 'SEM career playbook', 'sem-career-playbook:-overview-of-a-growing-industry.mp3'),
(119, 'What Is SEO Search Engine Optimization', 'seo', 'What Is SEO â€“ Search Engine Optimization?', 'SEO stands for â€œsearch engine optimization.â€ In simple terms, SEO means the process of improving your website to increase its visibility in Google, Microsoft Bing, and other search engines whenever people search.', 'What Is SEO', '<p>Want to know an easy way to speed up and improve the overall performance of your website?</p><p>Invest in good hosting.</p><p>Ignorance is no longer an excuse for any company to use a cheap web host.</p><p>Website performance is a critical element that can help improve your rankings, traffic and conversions.</p><p>This guide will cover everything you need to understand about why web hosting is important for SEO.</p><h2>What is website hosting</h2><p>A website hosting service provider, or web host, is a service that offers the technology required for a website to be viewed online.</p><p>Think of a web host as the home base of your website. Websites or webpages are stored on special computers called servers, and through the server your webpages get connected and delivered to internet browsers.</p><p>So, when users want to view your website, all they have to do is type your website address or domain into their browser.&nbsp;</p><p>When building a website, companies typically invest a lot of time and resources on design, development, digital marketing and SEO.</p><p>But web hosting is one area that tends to be an afterthought.</p><p>If you are willing to invest in making sure the website looks good and driving traffic to it, why not also ensure that the actual website is fast, functional and flexible?&nbsp;</p><p>Using a high-quality web host can maximize your conversion rates, along with other helpful benefits.&nbsp;</p><h2>How web hosting benefits businesses</h2><p>If you want a website for your business, then you will need a web host. Although web hosting is usually left at the back of a businessâ€™ mindset, it is crucial for your online presence.</p><p>A reliable web host can give your company a variety of benefits, such as:</p><ul><li>Improved site performance.</li><li>Effective data management.</li><li>Enhanced security.</li><li>High uptime.</li></ul><p>In short, investing in a reliable web host is wise â€“ and should help grow your business.&nbsp;</p><h2>Expected features from hosting providers</h2><p>Web hosts offer more than just web hosting services for businesses. Web host firms offer multiple services that ensure a hassle-free experience for business owners and to make sure their only focus is the time and energy spent on their business.</p><p>Here are some features you should expect from a good web hosting provider:&nbsp;</p><ul><li><strong>Email accounts:</strong>&nbsp;Hosting providers will require users to create their own domain name. Domain names and email accounts will be one of the features provided.&nbsp;</li><li><strong>FTP access:</strong>&nbsp;FTP allows you to upload files from a local computer to the web server. Your website will be accessible through the internet, with files transferred from your computer straight to the server using this feature. FTP access is critical for web developers.&nbsp;</li><li><strong>WordPress support:</strong>&nbsp;WordPress, which powers nearly half of the websites on the internet, is a convenient way to create and manage your website content.&nbsp;</li><li><strong>Enhanced security:</strong>&nbsp;Many hosting providers, such as WPEngine, now provide complimentary SSL certificates with their hosting services.</li></ul><p><br></p>', 'neranjan', '2023-10-07 18:09:52', '2023-10-07 18:10:57', 'Publish', 'what-is-seo-search-engine-optimization', 'en', 'what-is-seo-search-engine-optimization-1696702253.jpg', NULL, 'What Is SEO', 'what-is-seo-search-engine-optimization.mp3'),
(120, 'Web hosting for SEO: Why itâ€™s important?', 'seo', 'Web hosting for SEO: Why itâ€™s important', 'Web hosting for SEO: Why itâ€™s important Great web hosting won\'t put your website at the top of the search results, but it\'s a prerequisite for strong SEO results. Here\'s why.', 'Web hosting for SEO', '<p>Want to know an easy way to speed up and improve the overall performance of your website?</p><p>Invest in good hosting.</p><p>Ignorance is no longer an excuse for any company to use a cheap web host.</p><p>Website performance is a critical element that can help improve your rankings, traffic and conversions.</p><p>This guide will cover everything you need to understand about why web hosting is important for SEO.</p><h2>What is website hosting</h2><p>A website hosting service provider, or web host, is a service that offers the technology required for a website to be viewed online.</p><p>Think of a web host as the home base of your website. Websites or webpages are stored on special computers called servers, and through the server your webpages get connected and delivered to internet browsers.</p><p>So, when users want to view your website, all they have to do is type your website address or domain into their browser.&nbsp;</p><p>When building a website, companies typically invest a lot of time and resources on design, development, digital marketing and SEO.</p><p>But web hosting is one area that tends to be an afterthought.</p><p>If you are willing to invest in making sure the website looks good and driving traffic to it, why not also ensure that the actual website is fast, functional and flexible?&nbsp;</p><p>Using a high-quality web host can maximize your conversion rates, along with other helpful benefits.&nbsp;</p><h2>How web hosting benefits businesses</h2><p>If you want a website for your business, then you will need a web host. Although web hosting is usually left at the back of a businessâ€™ mindset, it is crucial for your online presence.</p><p>A reliable web host can give your company a variety of benefits, such as:</p><ul><li>Improved site performance.</li><li>Effective data management.</li><li>Enhanced security.</li><li>High uptime.</li></ul><p>In short, investing in a reliable web host is wise â€“ and should help grow your business.&nbsp;</p><h2>Expected features from hosting providers</h2><p>Web hosts offer more than just web hosting services for businesses. Web host firms offer multiple services that ensure a hassle-free experience for business owners and to make sure their only focus is the time and energy spent on their business.</p><p>Here are some features you should expect from a good web hosting provider:&nbsp;</p><ul><li><strong>Email accounts:</strong>&nbsp;Hosting providers will require users to create their own domain name. Domain names and email accounts will be one of the features provided.&nbsp;</li><li><strong>FTP access:</strong>&nbsp;FTP allows you to upload files from a local computer to the web server. Your website will be accessible through the internet, with files transferred from your computer straight to the server using this feature. FTP access is critical for web developers.&nbsp;</li><li><strong>WordPress support:</strong>&nbsp;WordPress, which powers nearly half of the websites on the internet, is a convenient way to create and manage your website content.&nbsp;</li><li><strong>Enhanced security:</strong>&nbsp;Many hosting providers, such as WPEngine, now provide complimentary SSL certificates with their hosting services.</li></ul><h2>Most popular web hosts</h2><p>Popular web hosting companies include:&nbsp;</p><ul><li>GoDaddy&nbsp;</li><li>Amazon Web Services</li><li>Google Cloud Platform&nbsp;</li><li>1&amp;1 IONOS&nbsp;</li><li>HostGator</li><li>Bluehost</li><li>Hetzner Online&nbsp;</li><li>DigitalOcean</li><li>Liquid Web&nbsp;</li><li>WP Engine&nbsp;</li></ul><h2>Why web hosting is important for SEO</h2><p>When it comes to SEO, Google strives to deliver the best possible results for its users.</p><p>This means that a strong and reliable web host will lay the foundation for your SEO efforts.</p><p>Google looks at several factors to ensure the user has a positive experience after using their search engine. Websites that work faster with improved UX can get a rankings boost.&nbsp;</p><p>SEO is a huge focus for nearly all businesses and brands today. Everyone wants their site listed on the first page of Google for relevant search queries.</p><p>Websites that fail to rank on Page 1 of Google likely wonâ€™t be found. As the saying goes, â€œthe best place to hide a website is the second page of Google.â€</p>', 'neranjan', '2023-10-07 18:14:37', '2023-10-07 18:18:47', 'Publish', 'web-hosting-for-seo-why-its-important', 'en', 'web-hosting-for-seo-why-its-important-1696702721.jpg', NULL, 'Web hosting', 'web-hosting-for-seo:-why-itâ€™s-important?.mp3'),
(121, 'What is PPC â€“ Pay-Per-Click marketing?', 'ppc', 'What is PPC â€“ Pay-Per-Click marketing?', 'PPC stands for pay-per-click. PPC is a form of online marketing where advertisers pay each time a user clicks on one of their ads. ', 'What is PPC', '<p>PPC stands for pay-per-click. PPC is a form of online marketing where advertisers pay each time a user clicks on one of their ads.&nbsp;</p><p>The most common form of PPC advertising is through search engines, such as Google Ads, where advertisers bid on keywords and their ads appear at the top of search engine results pages (SERPs) when those keywords are searched for.&nbsp;</p><p>PPC advertising can also be done through social media platforms, such as Facebook and Instagram, and through display advertising on websites.</p><p>What youâ€™ll learn in this guide:</p><ul><li><a href=\"https://searchengineland.com/guide/what-is-paid-search#ppc-sem-seo\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">The difference between PPC, SEM and SEO</a></li><li><a href=\"https://searchengineland.com/guide/what-is-paid-search#how-does-ppc-work\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">How PPC works</a></li><li><a href=\"https://searchengineland.com/guide/what-is-paid-search#why-is-ppc-important\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">Why PPC is important</a></li><li><a href=\"https://searchengineland.com/guide/what-is-paid-search#ppc-strategy-campaign-planning\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">PPC strategy and campaign planning</a></li><li><a href=\"https://searchengineland.com/guide/what-is-paid-search#top-ppc-ad-platforms\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">Top PPC platforms</a></li><li><a href=\"https://searchengineland.com/guide/what-is-paid-search#ppc-ad-types\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">Types of PPC ads</a></li><li><a href=\"https://searchengineland.com/guide/what-is-paid-search#how-to-learn-ppc\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">How to learn more about PPC</a></li></ul><h2>Whatâ€™s the difference between PPC, SEM and SEO?</h2><p>Though these three terms get used interchangeably, there is a difference between PPC,&nbsp;<a href=\"https://searchengineland.com/guide/what-is-sem\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">SEM</a>&nbsp;(search engine marketing), and&nbsp;<a href=\"https://searchengineland.com/guide/what-is-seo\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">SEO</a>&nbsp;(search engine optimization).&nbsp;</p><p>SEM is an umbrella term that encompasses PPC but is not limited to only this form of advertising. It references activity that intends to improve how easy it is to find a website through a search engine. SEM is both paid and unpaid, PPC, or organic traffic (SEO).&nbsp;</p><p>PPC is online advertising that works with search engines and other channels such as video ads (YouTube) and image ads (Instagram/Facebook).</p><p>Search engine optimization (SEO), is a method of optimizing a websiteâ€™s content and structure to make it more visible to search engines. This is done by researching and using relevant keywords, optimizing meta data, creating quality content, and earning links from other websites. The goal of SEO is to improve a websiteâ€™s organic (non-paid) search engine rankings and drive traffic to the website through organic search results.</p>', 'neranjan', '2023-10-07 18:21:43', '2023-10-07 18:21:43', 'Publish', 'what-is-ppc-pay-per-click-marketing', 'en', 'what-is-ppc-pay-per-click-marketing-1696702903.jpg', NULL, 'What is PPC', 'what-is-ppc-â€“-pay-per-click-marketing?.mp3'),
(122, '5 ways to get PPC and SEO working together', 'ppc', '5 ways to get PPC and SEO working together', 'Causes of friction between SEO and PPC often occur because we tend to use different sources of truth for each channel and build silos of communication between teams.', 'PPC and SEO', '<p>Causes of friction between SEO and PPC often occur because we tend to use different sources of truth for each channel and build silos of communication between teams.</p><p>The main core areas of friction? Usually:</p><ul><li>Reporting&nbsp;</li><li>Landing pages</li><li>Budget</li></ul><p>Here are five ways you can get your PPC and SEO campaigns working together.</p><h2>Tip 1: Collaborate on first-party data readiness</h2><p>All digital marketing campaigns need to account for first-party data.</p><p>Understanding whether your brand is compliant requires input from both your SEO and PPC teams.&nbsp;</p><p>If you rely heavily on remarketing campaigns (either because youâ€™re in an expensive industry or the customer journey naturally takes multiple steps), you may find yourself increasingly reliant on native audiences.</p><p>While some of these audiences can be powerful, most of them underperform against audiences based on brand-tracked activity.&nbsp;</p><p>Analytics audience segments can be a powerful way around fluctuating quality.</p><p>These audience segments still require consent and the new global site tag. Make sure your&nbsp;<a href=\"https://support.google.com/tagmanager/answer/9442095?hl=en\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">tag</a>&nbsp;is updated to GA4.&nbsp;</p><p>As you set up cookie consent, itâ€™s important that the module follows cumulative layout shift (CLS) rules. As a general rule, modules on the bottom of the page tend to do better as they donâ€™t distract from the userâ€™s purchasing journey, and carry less CLS risk.&nbsp;</p><p>Make sure that first-party data collected is protected (either hashed and synced through tools, or immediately deleted once itâ€™s been uploaded into ad accounts).</p><p>Collaborate with your SEO teamâ€™s content campaigns to ensure there are engaging hooks to create consensual conversations.&nbsp;&nbsp;</p>', 'neranjan', '2023-10-07 18:22:45', '2023-10-07 18:22:45', 'Publish', '5-ways-to-get-ppc-and-seo-working-together', 'en', '5-ways-to-get-ppc-and-seo-working-together-1696702965.jpg', NULL, 'PPC and SEO', '5-ways-to-get-ppc-and-seo-working-together.mp3'),
(123, 'Google Analytics 4 guide for PPC', 'ppc', 'Google Analytics 4 guide for PPC', 'Like many of you, the first time I looked at Google Analytics 4, I immediately closed it and said, â€œnope!â€ A year passed. Then we learned that Universal Analytics was going away in 2023, which finally forced me to explore GA4.', 'Google Analytics 4', '<p>Like many of you, the first time I looked at Google Analytics 4, I immediately closed it and said, â€œnope!â€</p><p>A year passed. Then we learned that&nbsp;<a href=\"https://searchengineland.com/google-deprecate-universal-analytics-on-july-1-2023-382648\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">Universal Analytics was going away in 2023</a>, which finally forced me to explore GA4.</p><p>It feels like going from Windows to Mac. You just have to know what youâ€™re looking at.</p><h2>Universal Analytics is going away</h2><p>You really need to install GA4 on your website and set up goals.</p><p>I cannot stress enough how important it is to install GA4 now, even if youâ€™re going to wait until July 2023 to fully learn how to use it.&nbsp;&nbsp;</p><p>In July 2023, UA will go away. You will need to be able to compare year-over-year data. You canâ€™t do that if you havenâ€™t installed GA4 on your website this year.</p><p>You will have to export reports from UA and GA4 and somehow combine them. You can do that in Data Studio, but it is a huge hassle.</p>', 'neranjan', '2023-10-07 18:23:44', '2023-10-07 18:23:44', 'Publish', 'google-analytics-4-guide-for-ppc', 'en', 'google-analytics-4-guide-for-ppc-1696703024.jpg', NULL, 'Google Analytics 4', 'google-analytics-4-guide-for-ppc.mp3'),
(124, 'A guide to Google: Origins, history and key moments in search', 'google', 'A guide to Google: Origins, history and key moments in search', 'Google is the most popular search engine in the world, with a commanding market share of over 80% globally and just under 80% in the U.S. While we donâ€™t have any figures direct from the company, itâ€™s estimated that billions of searches â€“ or trillion', 'Google', '<p>Google is the most popular search engine in the world, with a commanding market share of over 80% globally and just under 80% in the U.S.</p><p>While we donâ€™t have any figures direct from the company, itâ€™s estimated that billions of searches â€“ or trillions per year â€“ are conducted on Google.</p><p>Googleâ€™s immense popularity makes it an essential platform for brands and businesses that want to be visible and found by their target audiences when people are searching for products they sell or topics they have deep expertise and experience in.&nbsp;</p><p>This can be achieved with&nbsp;<a href=\"https://searchengineland.com/what-is-search-marketing-393902\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">search marketing</a>&nbsp;â€“ organically, by following&nbsp;<a href=\"https://searchengineland.com/guide/what-is-seo\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">SEO</a>&nbsp;best practices, via paid advertising (<a href=\"https://searchengineland.com/guide/what-is-paid-search\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">PPC</a>), or in combination.</p><h2>A brief history of Google</h2><p>Itâ€™s hard to imagine a time before Google dominated search. Google is a household name synonymous with search.</p><p>But back in the late 1990s, the search engine landscape was totally different.&nbsp;</p><p>At the time, Yahoo was the biggest player in search, but there were several other search engines including Excite, Lycos, AltaVista and Ask Jeeves.</p><p>But before Google would change search and marketing forever, there was BackRub.&nbsp;</p><p>This was the name of the search engine two Stanford PhD students â€“ Larry Page and Sergey Brin â€“&nbsp;started developing in 1996.</p><p>The name â€œBackrubâ€ came from how the search engine analyzed â€œbacklinksâ€ pointing to websites to understand their importance for ranking purposes.</p>', 'neranjan', '2023-10-07 18:26:46', '2023-10-07 18:26:46', 'Publish', 'a-guide-to-google-origins-history-and-key-moments-in-search', 'en', 'a-guide-to-google-origins-history-and-key-moments-in-search-1696703206.jpg', NULL, 'Google', 'a-guide-to-google:-origins,-history-and-key-moments-in-search.mp3'),
(125, 'Google search antitrust trial updates: Everything you need to know (so far)', 'google', 'Google search antitrust trial updates: Everything you need to know (so far)', 'Google search antitrust trial updates: Everything you need to know (so far) The landmark court case brought by the US Justice Department could spell huge changes for Google and the future of the Internet.', 'Google search antitrust', '<p>Google is on trial for allegedly using underhand tactics to ensure it stays the worldâ€™s leading search engine.</p><p>The U.S. Justice Department claims Google, which owns a 90% market share in search, paid massive sums to companies like Apple to make it the default search engine on products like the iPhone.</p><p>These multibillion-dollar deals gave Google an unfair advantage, the DOJ alleges, making it nearly impossible for rival companies to compete.</p><p>The trial will last 10 weeks and include testimonies from key figures like Alphabet and Google CEO Sundar Pichai.</p><p>The outcome of the landmark case could bring significant changes to Google and the future of the Internet. But itâ€™s equally likely the trial will result in no changes and Google will be free to continue operating however it wants.</p><p>Weâ€™ll keep updating this article with the latest developments from this landmark trial.</p><p>As the trial is set to cover many Google search-related issues, we have organized the updates by topic to make the timeline easier to follow.</p>', 'neranjan', '2023-10-07 18:26:48', '2023-10-07 18:26:48', 'Publish', 'google-search-antitrust-trial-updates-everything-you-need-to-know-so-far', 'en', 'google-search-antitrust-trial-updates-everything-you-need-to-know-so-far-1696703208.jpg', NULL, 'Google search antitrust', 'google-search-antitrust-trial-updates:-everything-you-need-to-know-(so-far).mp3'),
(126, 'Google resolves indexing issue with new content after nearly 6 hours', 'google', 'Google resolves indexing issue with new content after nearly 6 hours', 'Google resolves indexing issue with new content after nearly 6 hours Google confirmed the issue and said it delayed the indexing of newly published content between 1:30 pm and 7:20 p.m.', 'Google resolves indexing', '<p>Google confirmed it had some issues indexing and/or serving new content in Google Search. It started around 1:30 p.m. ET today. {Update: this is now resolved, see Postscript below.)</p><p><strong>Google statement.&nbsp;</strong>â€œIâ€™ve heard some sporadic reports, and weâ€™re checking on these,â€&nbsp;<a href=\"https://twitter.com/searchliaison/status/1710066784722706898\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">said</a>&nbsp;Googleâ€™s Search Liaison Danny Sullivan.</p><p>Forty minutes after publishing this article, Google confirmed having an issue with indexing new content. Google&nbsp;<a href=\"https://twitter.com/searchliaison/status/1710081976865361936\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">wrote</a>:</p><ul><li>â€œThereâ€™s an ongoing issue thatâ€™s delaying the indexing of newly published content. Weâ€™re working on identifying the root cause. You can monitor progress&nbsp;<a href=\"https://status.search.google.com/incidents/hJzAUmMsBkMsVpBBatXZ\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">here</a>&nbsp;on the Google Search Status Dashboard.â€</li></ul><p><strong>Reports.&nbsp;</strong>Edward Hyatt, the Director of Newsroom SEO at the Wall Street Journal,&nbsp;<a href=\"https://twitter.com/Edward_Hyatt/status/1710039593058263451\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">wrote</a>, â€œIndexing of new content in Search looks like it dropped around 2-3pm.â€</p><p>We will continue to monitor the potential issues and keep you posted in this story if there are any confirmed issues with Google Search index and serving.</p><p>I am seeing content being indexed and served by Google Search in the past hour or so, but Hyatt added, â€œtâ€™s still crawling existing content but not new URLS unfortunately..â€</p>', 'neranjan', '2023-10-07 18:26:56', '2023-10-07 18:26:56', 'Publish', 'google-resolves-indexing-issue-with-new-content-after-nearly-6-hours', 'en', 'google-resolves-indexing-issue-with-new-content-after-nearly-6-hours-1696703216.jpg', NULL, 'Google resolves indexing', 'google-resolves-indexing-issue-with-new-content-after-nearly-6-hours.mp3'),
(127, 'How to prepare for Google SGE: Actionable tips for SEO', 'seo', 'How to prepare for Google SGE: Actionable tips for SEO success', 'How to prepare for Google SGE: Actionable tips for SEO success Curious how Search Generative Experience will impact your organic traffic? Hereâ€™s what we know â€“ and don\'t know â€“ so far, and how to prepare.', 'How to prepare', '<p>While there are some reasonable assumptions of how Search Generative Experience (SGE) might affect our sites, others are not so realistic.&nbsp;</p><p>This article highlights:</p><ul><li>Theories about SGEâ€™s traffic impact.&nbsp;</li><li>What we know so far.&nbsp;</li><li>What we donâ€™t know yet.</li><li>Things to avoid.</li><li>Ways to prepare for SGE.</li></ul><h2>Theories on SGEâ€™s potential traffic impact</h2><p>SGE will undoubtedly impact organic search, with both positive and negative consequences, if it launches as it currently stands.</p><p>But how big will that impact be?</p><p>It is reasonable to assume that we could see a decrease in&nbsp;<a href=\"https://www.advancedwebranking.com/ctrstudy/\" target=\"_blank\" style=\"color: rgb(0, 147, 255);\">organic traffic of up to 30%</a>&nbsp;â€“ similar to how featured snippets impact some search results. This depends on the niche, business model and keyword types.</p><p>With that said, there is&nbsp;<strong>no</strong>&nbsp;magic number that can be generalized.</p><p>If there is no AI overview for the query, the impact will be close to zero.&nbsp;</p><p>If users are prompted to create an AI overview, a certain portion will follow through and create one.</p>', 'samali', '2023-10-14 18:29:05', '2023-10-14 18:29:17', 'Publish', 'how-to-prepare-for-google-sge-actionable-tips-for-seo', 'en', 'how-to-prepare-for-google-sge-actionable-tips-for-seo-success-1697308145.jpg', NULL, 'Google SGE', 'how-to-prepare-for-google-sge:-actionable-tips-for-seo.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `sitename` varchar(255) NOT NULL,
  `tagline` varchar(255) NOT NULL DEFAULT 'None',
  `domain` varchar(255) NOT NULL DEFAULT 'None',
  `sitelogo` varchar(255) DEFAULT NULL,
  `search_visibility` tinyint(1) DEFAULT 0,
  `meta_title` varchar(255) DEFAULT '',
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `sitename`, `tagline`, `domain`, `sitelogo`, `search_visibility`, `meta_title`, `meta_keywords`, `meta_description`) VALUES
(1, 'UpToWare', 'Science and Technology Journal', 'uptoware.com', 'upto-logo.png', 1, 'Search Engine Land - News, Search Engine Optimization (SEO)', 'Search Engine, SEO', 'Search Engine Land - News, Search Engine Optimization (SEO). Google said this update improves its \"coverage in many languages and spam types\" and will roll out over the next few weeks.');

-- --------------------------------------------------------

--
-- Table structure for table `socialmedia`
--

CREATE TABLE `socialmedia` (
  `id` int(11) NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `socialmedia`
--

INSERT INTO `socialmedia` (`id`, `facebook`, `twitter`, `instagram`, `linkedin`, `youtube`) VALUES
(1, 'https://web.facebook.com/', 'https://twitter.com/', 'https://www.instagram.com/', 'https://www.linkedin.com/', 'https://www.youtube.com/');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `second_name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `security_question1` varchar(255) NOT NULL,
  `security_answer1` varchar(255) NOT NULL,
  `security_question2` varchar(255) NOT NULL,
  `security_answer2` varchar(255) NOT NULL,
  `security_question3` varchar(255) NOT NULL,
  `security_answer3` varchar(255) NOT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `username`, `first_name`, `second_name`, `surname`, `email`, `password`, `security_question1`, `security_answer1`, `security_question2`, `security_answer2`, `security_question3`, `security_answer3`, `created_date`, `updated_date`) VALUES
(30, 'Admin', 'neranjan', 'Neranjan', 'Prasad', 'nRush', 'neranjan@gmail.com', '$2y$10$pGdY2XxXlgB3weFHvUx53.WcQdhui4hhhOe2UgZqAgU.KsRPJAhdK', 'What was your childhood nickname?', 'Abc@1234', 'What was your favorite place to visit as a child?', 'Abc@1234', 'What is your grandmother\'s maiden name?', 'Abc@1234', '2023-10-13 10:55:40', '2023-10-13 14:55:40'),
(31, 'Author', 'samali', 'Samali', 'Kasthuri', 'KSama', 'samali@gmail.com', '$2y$10$Oo45pOdTf.rvWW4BSzsQy.8KJrPObs/mgSaPxlKLJNddeCRL2DXZm', '', '', '', '', '', '', '2023-10-14 14:27:28', '2023-10-14 18:27:28'),
(32, 'Author', 'shanthi', 'Shanthi', 'Kumari', 'shanthiK', 'shanthi@gmail.com', '$2y$10$p21Mh9kmbjYnn0uktYHMCuf/Kml9ycpIkQJJ1QmMR4nRrVKdut2bS', '', '', '', '', '', '', '2023-10-14 14:51:23', '2023-10-14 18:51:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads_placement`
--
ALTER TABLE `ads_placement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `headerfooter`
--
ALTER TABLE `headerfooter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socialmedia`
--
ALTER TABLE `socialmedia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads_placement`
--
ALTER TABLE `ads_placement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `api`
--
ALTER TABLE `api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `headerfooter`
--
ALTER TABLE `headerfooter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `socialmedia`
--
ALTER TABLE `socialmedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
