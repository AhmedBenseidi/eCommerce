-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 08:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `market`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoures`
--

CREATE TABLE `categoures` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) NOT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categoures`
--

INSERT INTO `categoures` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(16, 'Bread and pastries', 'This category includes bread, pasta, biscuits, and pastries that are prepared without using wheat or any gluten-containing ingredients. There are diverse and delicious options of gluten-free bread along with other foods.', 10, 0, 0, 0),
(17, 'Grains and alternative grains', 'This category includes rice, corn, potatoes, quinoa, and gluten-free oats, which are considered healthy and nutrient-rich alternatives for individuals with gluten sensitivity.', 10, 0, 0, 0),
(18, 'Dairy products', 'This category includes milk, cheese, and yogurt that haven\'t been enhanced with gluten. There are plenty of tasty and nutritious options of gluten-free dairy products available.', 10, 0, 0, 0),
(19, 'Canned and processed foods', 'Many canned and processed foods are available gluten-free, such as soups, sauces, and ready meals. These options are convenient for individuals who want to avoid gluten and don\'t have time to prepare food from scratch.', 10, 0, 0, 0),
(20, 'Sweet treats', 'This category includes gluten-free desserts such as chocolate, cakes, and cookies. There are delicious options of sweet products that gluten-sensitive individuals can enjoy without causing any health issues.', 10, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(16, 'good', 0, '2024-05-13', 88, 1),
(17, 'Nice Prodect', 0, '2024-05-15', 102, 25);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL DEFAULT 'defulet.png',
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`) VALUES
(70, 'Fresh Kaiser rolls 5x60g', 'Fresh Kaiser rolls 5x60g. Gluten-free product\r\n\r\nGluten-free product specially prepared for people intolerant to gluten or avoiding it in their diet.\r\n\r\nIngredients: water, starch (tapioca, potato, maize), flour (rice, maize), rapeseed oil, yeast, egg white, fibre (plantain, soluble maize fibre), humectant (glycerol), sugar, salt, thickeners (xanthan gum, hydroxypropyl methyl cellulose).\r\n\r\nMay contain: sesame seeds, soya.\r\n\r\nTo be consumed by: (date on packaging). Store in a dry, ventilated and dark place. Once opened, the product should be stored in the refrigerator and consumed within 5 days.\r\n\r\nPreparation: Product for direct consumption.', '4', '2024-05-12', 'algeria', '644288523_bread.png', 'new', 0, 1, 16, 1),
(77, 'Pizza bases 2x150g', '150g pizza base. Gluten-free product\r\n\r\nIngredients: water, maize starch, sourdough 19%: rice flour, water; buckwheat flour, invert sugar syrup, rice flour, apple fibre, rice starch, sunflower oil, soya protein, sugar, salt, thickeners: hydroxypropylmethylcellulose, guar gum; yeast, fibre: pea, plantain. May contain sesame.\r\n\r\nBake with the ingredients for 5-8 minutes at 220-230°C.\r\n\r\nReady-to-eat product. To be consumed within 48h after opening.', '6', '2024-05-12', 'algeria', '61195939200_pizza2.png', 'new', 0, 1, 16, 25),
(87, 'Penne pasta 250g', 'Penne pasta 250g. Gluten-free product\r\n\r\n\r\nIngredients: corn starch, water, rice flour, pea protein isolate, salt, emulsifier: mono and diglycerides of fatty acids, thickening agent: E 464, acidity regulator: E575, colourant: beta carotene', '3', '2024-05-13', 'algeria', '58597287617_pasta.png', 'new', 0, 1, 16, 1),
(88, 'Spaghetti pasta, low protein PKU 250g', 'Spaghetti pasta, low protein PKU 250g\r\n\r\n\r\nIngredients: corn starch, gluten-free wheat starch, water, salt, emulsifier: mono and diglycerides of fatty acids; thickening agent: E464, acidity regulator: E575, colourant: beta carotene', '4.5', '2024-05-13', 'algeria', '95966088735_Spaghetti .png', 'new', 0, 1, 16, 1),
(89, 'Galician flour concentrate 500g', 'Galician flour concentrate 500g. Gluten-free product\r\n\r\nDeveloped especially for people intolerant to gluten.\r\n\r\nIngredients: corn starch, glucose, thickener: guar gum and E464, potato fiber, raising agent: sodium bicarbonate, acidity regulator: E575.\r\n\r\nProduct without wheat starch.\r\n\r\nUnit of measurement: packaging\r\n\r\nWeight: 500 g', '7', '2024-05-13', 'algeria', '71113149967_grains.png', 'new', 0, 1, 17, 1),
(90, 'Buckwheat flour 500g', 'Buckwheat flour 500g. Gluten-free product\r\n\r\n \r\n\r\nUnit of measurement: packaging\r\n\r\nWeight: 500 g\r\n\r\nStore in a dry, cool place.', '6', '2024-05-13', 'algeria', '84863411382_grains2.png', 'new', 0, 1, 17, 1),
(91, 'BAUCKHOF BIO Muesli 3-grains 225g', 'BAUCKHOF BIO Muesli 3-grains 225g. Gluten-free product\r\n\r\nIngredients: corn groats* 51%, corn semolina* 16%, rice flour* 9%, gluten-free wholegrain buckwheat flour* 9%, cane sugar*, roasted wholegrain amaranth flour*, roasted wholegrain quinoa flour*, sea salt.\r\n\r\n \r\n\r\n*certified organic ingredient.\r\n\r\n\r\nOrganic farming certificate DE-ÖKO-007.\r\n\r\n\r\nMay contain: soy, milk, cashews, walnuts, lac nuts, almonds; mustard, sesame, lupine.', '54', '2024-05-13', 'algeria', '96363903347_grain3.png', 'new', 0, 1, 17, 1),
(92, 'Oat flakes 1kg', 'Oat flakes. 1kg Gluten-free product\r\n\r\n\r\nStore in a dry place.', '10', '2024-05-13', 'algeria', '86102815078_grain4.png', 'new', 0, 1, 17, 1),
(93, 'TURTLE BIO cereal with chocolate chips 300g', 'TURTLE BIO cereal with chocolate chips 300g. Gluten-free product\r\n\r\nIngredients: rice*, maize bran*, dark chocolate chips* 11 % (cocoa pulp*, unrefined brown sugar*, cocoa fat*), unrefined cane sugar*, salt (*certified organic ingredient)\r\n\r\nDESCRIPTION\r\nIdeal as an addition to MILK, yoghurt or your favourite vegetable drink.\r\nHigh in dietary fibre', '25', '2024-05-13', 'algeria', '45582526566_sweet.png', 'new', 0, 1, 20, 1),
(94, 'TURTLE BIO dark chocolate-covered cornflakes 250g', 'TURTLE BIO dark chocolate-covered cornflakes 250g. Gluten-free product\r\n\r\nIngredients: cornflakes* 60 % (corn*, unrefined cane sugar*, sea salt, corn malt*), dark chocolate* 40 % (cocoa pulp*, unrefined cane sugar*, cocoa fat*) (*certified organic ingredient)', '30', '2024-05-13', 'algeria', '14079321077_sweet1.png', 'new', 0, 1, 20, 1),
(95, 'CELIKO Baton owocowy Frupp - wiśniowy 10g.', 'CELIKO Baton owocowy Frupp- wiśniowy. Produkt bezglutenowy\r\n\r\nSkładniki: wiśnie (30%), koncentrat soku jabłkowego (5%), mieszanina żelująca (cukry trehaloza, sacharoza, maltodekstryna, substancja żelująca: pektyna jabłkowo-cytrusowa\r\n\r\n ', '21', '2024-05-13', 'algeria', '79468930258_sweet2.png', 'new', 0, 1, 20, 1),
(96, 'CELIKO Koncentrat ciasta brownie 300g', 'CELIKO Koncentrat ciasta brownie 300g. Produkt bezglutenowy.\r\n\r\n\r\nSkładniki: cukier, mąka ryżowa, skrobia kukurydziana, skrobia z tapioki, kakao o obniżonej zawartości tłuszczu (10-12%)- 8%, czekolada (masa kakaowa, cukier, kakao o obniżonej zawartości tłuszczu, emulgator: lecytyna sojowa) - 4%, błonnik kakaowy, substancja zagęszczająca: guma ksantanowa; aromat, sól.\r\n\r\nMoże zawierać: mleko i ich pochodne.\r\n\r\nPrzechowywać w suchym i chłodnym miejscu.', '35', '2024-05-13', 'algeria', '76791013689_sweet3.png', 'new', 0, 1, 20, 1),
(97, 'Go Nuts Cocoa cream with hazelnuts 350g', 'Go Nuts Cocoa cream with hazelnuts 350g. Gluten-free product\r\n\r\n \r\n\r\nIngredients: sweetener: maltitol; whey protein 27%, vegetable oils and fats (rapeseed, cocoa and sunflower butter), hazelnuts 10%, skimmed cocoa powder 8%, inulin, emulsifier: sunflower lecithin, natural vanilla flavor.\r\n\r\nMay contain soy and other nuts.\r\n\r\nExcessive consumption may cause a laxative effect\r\n\r\nSeparation of the product is a natural phenomenon and results from the lack of added sugars.\r\n\r\nStore in a cool and dry place. After opening, store in the refrigerator. Best before: date and batch number on the packaging', '40', '2024-05-13', 'algeria', '6528689638_sweet4.png', 'new', 0, 1, 20, 1),
(98, 'Silk Dairy', 'Silk Dairy Free, Gluten Free, Unsweet Almond Milk, 64 fl oz Half Gallon', '50', '2024-05-13', 'algeria', '54178042016_siik.png', 'new', 0, 1, 18, 1),
(99, 'Silk Dark Chocolate Almondmilk', 'Treat yourself to this smooth and seriously creamy Silk Dark Chocolate Almondmilk. Enjoy all of the taste with 25% less sugar than dairy chocolate milk.* Made with three kinds of almonds grown by Mother Nature and picked at the peak of ripeness, this lactose free milk has a perfect mix of quality and flavor', '65', '2024-05-13', 'algeria', '91527555548_silk.png', 'new', 0, 1, 18, 1),
(100, 'Heinz Baked Beans', 'Heinz, makers of the most popular gluten-free ketchup brand, also markets baked beans in numerous different varieties, including Original, Bourbon & Molasses, Bacon & Brown Sugar, Bold & Spicy, Hickory Smoke, Molasses & Pork, and Sweet & Spicy.\r\n\r\nHowever, only three of these varieties are considered gluten-free by the company: Original, Hickory Smoke, and Molasses & Pork. None of these three flavors are vegetarian.\r\n\r\nNote that all three gluten-free Heinz baked bean flavors contain distilled vinegar, but Heinz uses vinegar that&#39;s derived from corn. Also note that the Hickory Smoke baked beans contain smoke flavoring, but that ingredient does not include barley (most smoke flavoring does include barley as an ingredient).', '22', '2024-05-13', 'algeria', '66309850217_canned.png', 'new', 0, 1, 19, 1),
(101, 'Green Beans Canned', 'Great Value Canned Cut Green Beans are picked at the peak of ripeness and packed within hours to seal in farm fresh goodness for deliciously mild, subtly sweet flavor and crisp-tender texture. Full of natural goodness, these green beans are great as a standalone side dish, snack, or an ingredient in your green bean casserole. ', '11', '2024-05-13', 'algeria', '3575833562_canned1.png', 'new', 0, 1, 19, 1),
(102, 'Pacific Foods Organic', 'Immerse your taste buds into something truly unique with Pacific Foods Organic Cream of Chicken Soup. This canned soup is a savory blend of roasted chicken, cream and garlic. Enjoy this condensed soup on its own, customize it with toppings, or pair it with a salad, sandwich or wrap. You can also use it in recipes like homemade soups and casseroles. USDA-certified organic and made with non-GMO ingredients, this chicken soup is gluten free and made without additives. Simply pour, add 1 can of milk, heat, stir and enjoy. Every spoonful of our organic soup is satisfying to the last drop.', '14', '2024-05-13', 'algeria', '80647002013_canned3.png', 'new', 0, 1, 19, 1),
(103, 'Swanson 100% Natural', 'Elevate your homemade meals with the rich, full-bodied flavor of Swanson Chicken Broth. Swanson’s canned chicken broth brings together the perfectly balanced flavors of farm-raised chicken, vegetables picked at the peak of freshness, and high-quality seasonings in a convenient recyclable can. And just like homemade, our canned broth uses only 100% natural, non-GMO ingredients, with no MSG added*, no artificial flavors or colors, and no preservatives. More convenient than chicken bouillon, this fat-free, gluten-free chicken broth is a versatile ingredient for your everyday cooking, adding flavor and moisture to both entrees and side dishes. It’s great as a soup base, and it can be used instead of water to boost rich flavor in rice, pasta and veggies. Swanson Chicken Broth is a must-have-for your holiday cooking, bringing richer, elevated homemade flavor to mashed potatoes, stuffing and more. It’s not just any broth. It’s Swanson. In addition to chicken broth, Swanson offers a variety of other delicious broths, including Beef and Vegetable. Try Swanson Chicken Stock for even richer flavor and a heavier texture that’s great for adding body to sauces, gravies and more. *Small amount of glutamate occurs naturally in yeast extract This product is packaged in a metal can, and is shelf-stable/ambient.\r\nOne 14.5 ounce recyclable can of Swanson 100% Natural Chicken Broth\r\nPerfectly balanced flavors of farm-raised chicken, fresh-picked vegetables, and high-quality seasonings\r\nFat-free, gluten-free chicken broth made with 100% natural, non-GMO ingredients; no artificial flavors or colors and no preservatives\r\nA must-have for your holiday cooking; adds richer, elevated homemade flavor to mashed potatoes, stuffing and more\r\nUse it to add flavor and moisture to entrees and side dishes, as a soup base, or in place of water to boost rich flavor in rice and pasta\r\nNot just any broth. It’s Swanson.\r\nThis product is packaged in a metal can, and is shelf-stable/ambient.', '65', '2024-05-13', 'algeria', '38330358257_canned4.png', 'new', 0, 1, 19, 1),
(104, 'foods', 'azertyuiop^qsdfghjklmùwwccvcbncctyftftfftftftftyfghvty', '20', '2024-05-15', 'djelfa', '35211017160_plastic-collector.png', 'good', 0, 0, 16, 25);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Order_ID` int(11) NOT NULL,
  `Addrasse` varchar(255) NOT NULL,
  `Card_Num` varchar(255) NOT NULL,
  `CVC` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `User` int(11) NOT NULL,
  `Item` int(11) NOT NULL,
  `Mount` float NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Card_Exp` date NOT NULL,
  `AddDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Order_ID`, `Addrasse`, `Card_Num`, `CVC`, `Email`, `User`, `Item`, `Mount`, `Quantity`, `Card_Exp`, `AddDate`) VALUES
(6, 'Ain El Melh Msila', '1111111111111', '000', 'aimenbelakhit@gmail.com', 1, 77, 12, 2, '2024-05-21', '2024-05-15 00:48:40'),
(7, 'Ain El Melh Msila', '123456789', '102', 'Ahmed@gmail.com', 25, 102, 42, 3, '2026-07-15', '2024-05-15 00:49:42'),
(8, 'Ain El Melh Msila', '123456789', '012', 'Ahmed@gmail.com', 25, 99, 130, 2, '2024-06-07', '2024-05-15 00:51:43'),
(9, 'Ain El Melh Msila', '1111111111111', '102', 'Ahmed@gmail.com', 25, 101, 22, 2, '2024-05-28', '2024-05-15 00:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Fullname` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0,
  `TrustStatus` int(11) NOT NULL DEFAULT 0,
  `RegStatus` int(11) NOT NULL DEFAULT 0,
  `Date` date NOT NULL,
  `Avater` varchar(255) NOT NULL DEFAULT 'defulet.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `Fullname`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `Avater`) VALUES
(1, 'aimen ', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'aimenbelakhit@gmail.com', 'aimenbelakhit  ', 1, 1, 1, '0000-00-00', '38766169701_Gluten_Free_Market.png'),
(25, 'Ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Ahmed@gmail.com', '', 1, 0, 1, '2024-05-12', 'defulet.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoures`
--
ALTER TABLE `categoures`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `item_order` (`Item`),
  ADD KEY `user_order` (`User`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Username_2` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoures`
--
ALTER TABLE `categoures`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categoures` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `item_order` FOREIGN KEY (`Item`) REFERENCES `items` (`Item_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_order` FOREIGN KEY (`User`) REFERENCES `users` (`UserID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
