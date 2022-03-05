-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 05 mars 2022 à 14:57
-- Version du serveur : 5.7.33
-- Version de PHP : 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `title`) VALUES
(1, 'Développement web'),
(2, 'Jeux vidéos'),
(3, 'Lecture'),
(4, 'Technologies'),
(5, 'Musique'),
(6, 'Voyage'),
(7, 'Animaux'),
(8, 'Finances'),
(9, 'Politique'),
(10, 'Écologie'),
(11, 'Mode'),
(14, 'Santé');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `content` text NOT NULL,
  `status` enum('validated','refused','pending') NOT NULL DEFAULT 'pending',
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `date`, `content`, `status`, `user_id`, `post_id`) VALUES
(4, '2022-01-16 19:17:35', 'J\'aimerais bien apprendre à programmer en Python, par où commencer ?', 'validated', 1, 1),
(7, '2022-01-25 22:35:32', 'Merci pour cet article !', 'pending', NULL, 1),
(12, '2022-01-26 10:26:38', 'Test 1', 'validated', 6, 1),
(13, '2022-02-05 16:33:40', 'Il paraît qu\'une seule recherche Google émet 0,2 grammes de C02 tandis qu\'il faut consommer 0.0003 kWh d\'énergie pour faire une requête soit 1 kilojoule. Cela représente à peu près autant d\'énergie que ce qu\'un corps humain adulte brûle en 10 minutes.', 'validated', 1, 14),
(21, '2022-02-05 17:25:25', 'Les machines nous envahissent !!!', 'validated', 1, 4),
(23, '2022-02-06 19:09:29', 'Test 1', 'pending', 1, 4),
(24, '2022-02-06 19:09:39', 'Test 2', 'pending', 1, 1),
(25, '2022-02-06 19:09:46', 'Test 3', 'pending', 1, 4),
(38, '2022-02-09 09:23:57', 'I\'m Batman', 'validated', NULL, 11),
(39, '2022-03-05 09:45:08', 'Bonne chance à tous !', 'pending', 1, 11),
(40, '2022-03-05 09:49:09', 'Premier commentaire !', 'pending', 1, 12),
(41, '2022-03-05 12:34:36', 'Je ne suis pas connecté.', 'validated', NULL, 14);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `headline` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `creation_date` date NOT NULL,
  `update_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `headline`, `image`, `content`, `status`, `creation_date`, `update_date`, `user_id`, `category_id`) VALUES
(1, 'Quel langage de programmation choisir ?', 'Connaître un langage de programmation est un atout de plus en plus important sur le marché du travail, puisque la demande en ingénieurs logiciels, déjà en hausse, va augmenter de beaucoup au cours des prochaines années. Cependant, quand on débute dans la programmation, on peut être confus face aux centaines de langages que l’on peut choisir. Voici une liste des langages de programmation les plus connus, pour vous aider à vous décider.', './public/img/langage.jpg', 'Python, le plus facile \r\nPython est un langage de programmation open source interprété côté serveur et non compilé. Créé par Guido van Rossum, il est utilisé pour le développement web, le développement de jeux vidéos et autres logiciels, ainsi que pour les interfaces utilisateur graphiques. Il a notamment été utilisé dans la création d’Instagram, de YouTube et de Spotify, et est l’un des langages de programmation officiels de Google.\r\n\r\nPython a plusieurs avantages. Tout d’abord, il est le langage de programmation le plus facile à apprendre. De plus, il a de nombreux outils et fonctionnalités qui facilitent la programmation, et il est considéré comme l’Internet des objets, puisque beaucoup de plateformes, comme Raspberry Pi, se basent dessus.\r\n\r\nCependant, il est plus lent que les scripts compilés, est peu adapté pour le développement de logiciels pour mobiles, et ses utilisateurs se plaignent souvent de son design, qui nécessitent plus de tests que pour les autres langages, et qui a des erreurs qui n’apparaissent que lors de la mise en marche.\r\n\r\nJava, le plus connu\r\nJava est sûrement le langage de programmation le plus connu. Il est utilisé par les développeurs pour créer et faire fonctionner des applications pour ordinateurs. Il est probablement donc en fonction sur votre ordinateur et sur votre navigateur web. Il est également utilisé sur la plupart des autres supports numériques (smartphones, consoles, logiciels).\r\n\r\nLes développeurs connaissant Java sont très demandés, et le langage évolue sans cesse, alors le défi est permanent. Cependant, le langage Java consomme beaucoup plus de mémoire que le C++ et ses simulations sont lentes. De plus, ce n’est pas le langage le plus facile à apprendre (même si ce n’est pas le plus dur non plus).\r\n\r\nC, l’un des plus vieux\r\nCréé entre 1969 et 1973, C est l’un des langages de programmation les plus vieux. Ce langage de programmation impérative d’usage général supporte la programmation structurée, les variations de lexique et les récusions, tandis qu’un système de type statique empêche beaucoup d’opérations accidentelles. Ce langage est utilisé pour les systèmes d’exploitation, le développement de logiciel, et le hardware.\r\n\r\nLe langage C a l’avantage de permettre le développement de logiciels pouvant fonctionner sur différentes plateformes sans trop de modifications. De plus, il est assez simple et peut donc être intégré sur presque n’importe quel microprocesseur moderne.\r\n\r\nLe plus grand avantage de ce langage est que les langages de programmation contemporains en sont quasiment tous plus ou moins dérivés. Ainsi, une fois que l’on connaît le langage C, les autres langages deviennent beaucoup plus simples. Néanmoins, ce langage a ses inconvénients. En effet, le langage C n’a aucun mécanisme de vérification concernant l’exécution, ne supporte pas la programmation orientée objet (ce qui est la raison pour laquelle le langage C++ a été créé), et n’est pas très facile à apprendre.\r\n\r\nC++, complexe\r\nC++ est un langage de programmation orientée objet (comblant les lacunes du langage C) considéré comme le meilleur langage quand il s’agit de créer des applications à grande échelle. Il est notamment utilisé pour développer des logiciels, des systèmes d’exploitation, des jeux vidéos et des moteurs de recherche. Apprendre ce langage vous fera remarquer parmi les programmeurs et vous permettra de programmer une application qui fonctionnera tout en respectant les capacités de votre ordinateur.\r\n\r\nPar contre, il faut savoir que le C++ est un énorme langage très dur à apprendre, car très complexe. Il s’agit malgré tout d’un langage très enseigné dans les écoles de génie.\r\n\r\nJavaScript, le plus demandé\r\nJavaScript est souvent utilisé comme un langage de script côté client, ce qui signifie que son code est inscrit dans une page HTML. Quand un utilisateur affiche une page ayant JavaScript, le script est envoyé au navigateur, qui doit alors réagir. On retrouve JavaScript dans les devantures de sites, les outils analytiques, les widgets et les interactions web. Ce langage de programmation est très facile à apprendre, et peut être utilisé avec d’autres langages. En plus, ses fonctions peuvent être exécutées immédiatement. Les seuls inconvénients sont le fait que JavaScript peut être exploité en tant que brèche de sécurité, et le fait qu’il peut être interprété différemment selon les navigateurs.\r\n\r\nC#, puissant et flexible\r\nC# est un langage de programmation puissant et flexible, qui peut être utilisé pour des logiciels et applications divers. Avec ce langage, vous pouvez généralement développer ce que vous voulez. De plus, avec la bibliothèque .NET, vous avez accès à un grand répertoire de fonctionnalités. Ce n’est pas le seul avantage : la structure que vous apprenez avec C# est basée sur C, alors elle peut être transférée à d’autres langages de programmation. Cependant, le C# est dur à apprendre et n’a aucune capacité multiplateforme, mais le jeu en vaut la chandelle car les codeurs qui le maîtrisent sont parmi les plus demandés.\r\n\r\nRuby, à usage général\r\nRuby est un langage de programmation d’usage général, orienté objet, dynamique et réflectif. Il est utilisé pour les interfaces utilisateur graphiques, les applications web et le développement web. Ruby est apprécié des débutants en codage, car il est l’un des langages de programmation les plus faciles à apprendre et a une bibliothèque d’outils et de fonctionnalités bien fournie. De plus, il y a une véritable communauté autour de ce langage, les adeptes de Ruby se rencontrant autant sur Internet qu’en personne. Cependant, même ces adeptes reconnaissent que Ruby est lent, qu’il y a peu de bonne documentation dessus et que les applications développées avec ce langage sont moins performantes que celles développées par Java ou C.\r\n\r\nPHP, facile à apprendre, mais lent\r\nPHP est un langage de script côté serveur utilisé pour le développement web, mais également comme langage de programmation d’usage général. Il est facile à apprendre, et possède une large communauté. De plus, il fonctionne bien avec les bases de données, les systèmes de fichiers, les images, etc. Néanmoins, ce code a de gros défauts : à cause de sa facilité, les novices ont tendance à ne pas utiliser ce code correctement, sans compter le fait que certains des codes open source sont très vieux. PHP est aussi plus lent que ses concurrents, et sa gestion des erreurs est très mauvaise.\r\n\r\nObjective-C, langage principal d’Apple pour OS X et i OS\r\nObjective-C est un langage de programmation d’usage général et orienté objet, qui ajoute une messagerie de style Smalltalk au langage C. C’est le langage de programmation principal d’Apple pour les systèmes d’exploitation OS X et iOS, ainsi que pour leurs interfaces de programmation. Objective-C a pour avantage de donner accès aux bibliothèques de développement d’Apple. De plus, les programmes développés avec Objective-C sont plus dynamiques, et peuvent prendre eux-mêmes des décisions concernant la mémoire et les données. Cependant, ce langage ne peut pas être utilisé sur d’autres plateformes, et est long et difficile à apprendre.\r\n\r\nEn résumé, Python est le langage le plus facile à apprendre, C++ est le plus puissant, JavaScript est le plus demandé, et Java a la meilleure longévité.', 1, '2022-01-12', '2022-01-12', 1, 1),
(3, 'Les 10 bienfaits de la lecture: à vos bouquins ', 'C\'est quand la dernière fois que vous avez pris le temps de lire un livre, ou alors un long article dans votre revue préférée ? Est-ce que vos habitudes de lecture gravitent plutôt autour de Facebook, de Twitter, ou de la liste d\'ingrédients de votre soupe instantanée ? Si vous faites partie des nombreuses personnes qui n\'ont pas l\'habitude de lire tous les jours, vous passez à côté de beaucoup de bienfaits. Vous vous demandez à quoi sert de lire ? Découvrez vite les 10 bienfaits associés à une lecture quotidienne.', './public/img/lecture.jpg', '1. Stimule le cerveau L\'impact de la lecture sur le cerveau est une réalité. Plusieurs études indiquent que la stimulation mentale peut ralentir l\'évolution (et peut-être même l\'arrêter complètement) de la maladie d\'Alzheimer et de la démence. Pourquoi faut-il lire ? La raison est simple : garder son cerveau actif l\'empêche de perdre ses capacités. Comme tous les autres muscles du corps, le cerveau a besoin d\'entraînement pour rester vigoureux et en bonne santé. La règle « on s\'en sert ou on le perd » s\'applique parfaitement en ce qui concerne notre cerveau. Du coup, les jeux qui stimulent notre intellect, comme les puzzles ou les échecs, sont aussi bénéfiques à la santé de notre cerveau. \r\n\r\n2. Diminue le stress Autre argument en faveur de la lecture : lire diminue le stress. Que ça soit du stress lié au boulot ou à des soucis liés à votre quotidien, peu importe, la lecture diminue notre état d\'anxiété. Un roman peut tout simplement nous transporter dans une autre dimension. Autre avantage de la lecture : un article intéressant peut nous distraire. La lecture permet aussi de voyager et de s\'évader sans quitter notre canapé. Elle a la capacité d\'alléger notre anxiété et de nous détendre complètement. Les bienfaits de la lecture avant de dormir sont d\'ailleurs reconnus. Essayez de lire un peu avant d\'éteindre la lumière. Vous verrez que vous vous endormez beaucoup plus rapidement. \r\n\r\n3. Améliore les connaissances La lecture enrichit l\'esprit. C\'est une de ses vertus et pas la moindre ! Quand on lit, on remplit notre cerveau avec de nouvelles informations — et on ne sait jamais quand on elles nous seront utiles. Plus on a de connaissances, mieux on est équipé pour affronter de nouveaux défis. Voici pour vous matière à réflexion. Si vous êtes amené à tout perdre dans votre vie : votre emploi, vos biens, et même votre santé... Souvenez-vous qu\'on ne pourra jamais vous retirer votre savoir et vos connaissances. \r\n\r\n4. Accroît le vocabulaire C\'est un bienfait étroitement lié à la connaissance. Plus on lit, plus on découvre de nouveaux mots, et plus il y a de chances de les employer dans son langage quotidien. S\'exprimer de manière éloquente et précise est un précieux atout professionnel. Être capable de communiquer avec ses supérieurs en ayant confiance en soi est un excellent moyen d\'améliorer son estime de soi. D\'où l\'importance de la lecture ! Enrichir son vocabulaire peut même faire avancer sa carrière. Il permet de mieux maîtriser les différents registres de langue. En effet, les personnes instruites, éloquentes, et ayant des connaissances sur plein de sujets différents ont plus de chances d\'être promues (et ce, plus souvent). Elles ont plus de probabilités de faire évoluer leur carrière que les personnes qui possèdent un vocabulaire plus restreint... Ou celles encore qui ont peu de connaissances en littérature, sur les avancées scientifiques et les actualités mondiales. La lecture a aussi un effet bénéfique pour apprendre une langue étrangère. Lire un livre dans une autre langue permet de voir des mots utilisés dans leur contexte. Cela améliore aussi bien l\'écrit que l\'oral. \r\n\r\n5. Améliore la mémoire Pour bien comprendre un livre, on doit se souvenir d\'une multitude d\'informations. L\'intérêt de la lecture est qu\'elle fait travailler la mémoire. Il faut en effet retenir les personnages, leur passé, leurs intentions, leur vécu, puis les nuances, et toutes les actions secondaires qui s\'entremêlent à l\'action principale. Ça représente beaucoup d\'informations à retenir. Mais le cerveau est un organe miraculeux qui va s\'en souvenir avec une aisance surprenante. Le plus épatant est que chaque fois que l\'on forme une nouvelle mémoire, on crée de nouvelles synapses (des zones de contacts entre les neurones). Et on solidifie les synapses existantes. Ça veut dire que la lecture, en formant de nouvelles mémoires, va augmenter nos capacités de rétention de mémoires à court terme. Et cela a un effet régulateur sur notre humeur. Plutôt pas mal, non ? \r\n\r\n6. Développe les capacités d\'analyses Est-ce qu\'il vous est déjà arrivé de lire un bon p\'tit roman policier et de deviner qui était l\'assassin avant même la fin du livre ? Si c\'est le cas, vous avez fait preuve de bonnes aptitudes critiques et analytiques. Vous avez synthétisé tous les détails et les arguments fournis pour faire un vrai travail de détective. Cette capacité d\'analyse des détails est également bénéfique pour critiquer l\'action d\'un livre. On peut juger s\'il est bien écrit, si les personnages sont bien développés, si l\'intrigue se déroule de manière fluide, etc. Si un jour vous devez échanger votre avis sur un livre avec une autre personne, cette capacité d\'analyse va vous permettre d\'exprimer votre avis de manière claire. Pourquoi ? Car vous aurez analysé et critiqué intérieurement les détails pertinents pendant votre lecture. \r\n\r\n7. Améliore l\'attention et la concentration Les bienfaits de la lecture sur les capacités cognitives sont nombreux. Dans nos sociétés qui gravitent autour d\'Internet et du « multi-tâches », notre capacité à nous concentrer est attaquée de toutes parts. En 5 min de temps, l\'individu moyen va diviser son temps entre travailler sur 1 tâche, vérifier ses courriers électroniques... Sans oublier qu\'il va échanger des messages avec plusieurs personnes simultanément (Facebook, Skype, etc.), lire son compte Twitter, vérifier son smartphone et tenir une conversation avec ses collègues ! Ce comportement hyperactif génère du stress et ralentit la productivité. Quand on lit un livre, c\'est tout le contraire. Toute notre attention est dirigée vers l\'intrigue de l\'ouvrage. Et c\'est un des avantages de la lecture. C\'est comme si le reste du monde se dissolvait et qu\'on pouvait plonger complètement dans les détails du récit. C\'est pourquoi la lecture est essentielle aussi pour les enfants dès la primaire et chez les jeunes. Le matin, essayez 15 à 20 min de lecture avant d\'aller au boulot (dans le bus ou dans le métro, par exemple). Vous allez être surpris par l\'effet positif que ça va avoir sur votre niveau de concentration, une fois au travail. \r\n\r\n8. Améliore la rédaction Autre argument en faveur de la lecture : mieux écrire va de pair avec enrichir son vocabulaire. On peut dire que lire aide à mieux apprendre le français. La lecture d\'œuvres publiées et bien écrites va avoir un effet notoire sur votre propre style de rédaction. Observer la cadence, la fluidité, et le style d\'autres auteurs va inévitablement influencer votre propre manière d\'écrire. De la même façon que les musiciens ont une influence sur la musique de leurs confrères, et que les peintres s\'inspirent de la technique des maîtres... Les écrivains créent des récits en s\'inspirant du travail d\'autres auteurs. \r\n\r\n9. Tranquillise l\'esprit À la base, la lecture est synonyme de relaxation. C\'est un autre intérêt indéniable de la lecture. Mais au-delà de cette qualité reconnue, la thématique d\'un livre peut aussi nous apporter la tranquillité d\'esprit et une paix intérieure considérable. En effet, la lecture de textes spirituels peut faire baisser la tension artérielle et suscite un sentiment de calme. De plus, il a été démontré que les livres de développement personnel peuvent aider les personnes qui souffrent de certains troubles de l\'humeur et de formes légères de maladies mentales. \r\n\r\n10. Un divertissement gratuit La plupart des gens aiment bien posséder le livre qu\'ils lisent, pour pouvoir y noter des commentaires à l\'intérieur ou alors marquer les pages intéressantes. Mais les livres peuvent être coûteux. Pour profiter d\'un divertissement vraiment peu cher, vous pouvez visiter votre médiathèque de quartier et découvrir les tomes innombrables qui y sont disponibles, gratuitement. Les médiathèques proposent des ouvrages sur tous les sujets imaginables. Et comme elles font régulièrement « tourner » leur stock, il y a souvent de nouveaux arrivages. Elles sont véritablement une source inépuisable de divertissement. Par un malheureux hasard, vous habitez dans un endroit sans bibliothèque ou que vous ne pouvez pas vous déplacer ? Sachez que la plupart des médiathèques proposent un e-service pour télécharger les livres en format PDF sur votre liseuse, iPad, ou ordinateur. De plus, savez-vous que le lecture en ligne gratuite sur internet est très développée ? Il existe plusieurs sites de téléchargement gratuit d\'ouvrages. Alors, qu\'attendez-vous pour les explorer ? \r\n\r\nIl n\'y a pas un livre à lire absolument. Tout dépend de vos passions et de vos goût en lecture. Il existe un genre littéraire adapté à chaque personne qui sait lire et écrire. Peu importe votre préférence : la littérature classique ou philosophique, la poésie, les revues de mode, les biographies, les textes spirituels, les oeuvres classiques, un nouveau roman ou les livres de développement personnels, etc. Il y aura toujours un ouvrage qui va complètement captiver votre attention et votre imagination. Vous ne pensez pas qu\'il est temps d\'éteindre votre ordi, mettre votre téléphone en mode silencieux, et de prendre un petit moment pour ressourcer votre âme ?', 0, '2022-01-19', '2022-03-05', 1, 3),
(4, 'Meta dévoile un nouveau superordinateur', 'Meta Platforms Inc., la société mère de Facebook, a annoncé lundi que son équipe de recherche a construit un nouveau superordinateur d\'intelligence artificielle (IA) qui, selon elle, sera le plus rapide du monde lorsqu\'il sera achevé à la mi-2022. Baptisé \"AI Research SuperCluster\" (RSC), le supercalculateur devrait aider l\'entreprise à construire de meilleurs modèles d\'intelligence artificielle capables d\'apprendre à partir de milliers de milliards d\'exemples, de travailler dans des centaines de langues et d\'analyser ensemble du texte, des images et des vidéos pour déterminer si le contenu est nuisible.', './public/img/10.jpeg', 'Le RSC serait le résultat de près de deux ans de travail, souvent mené à distance au plus fort de la pandémie, et dirigé par les équipes d\'IA et d\'infrastructure de Meta. L\'entreprise a précisé que plusieurs centaines de personnes, dont des chercheurs des partenaires comme Nvidia, Penguin Computing et Pure Storage, ont participé au projet. Meta, qui a annoncé la nouvelle dans un billet de blogue lundi, a déclaré que son équipe de recherche utilise actuellement le superordinateur pour former des modèles d\'IA dans le traitement du langage naturel (NLP - Natural Language Processing) et la vision par ordinateur pour la recherche.\r\n\r\n\r\n\r\n\r\nSelon la société, l\'objectif est d\'augmenter les capacités afin de former un jour des modèles avec plus de 1 000 milliards de paramètres sur des ensembles de données aussi grands qu\'un exaoctet (soit 1 000 pétaoctets ou un milliard de gigaoctets), ce qui équivaut à peu près à 36 000 ans de vidéo de haute qualité. Le supercalculateur d\'IA de Meta abrite 6 080 GPU de type Nvidia A100, ce qui le place au cinquième rang des supercalculateurs les plus rapides au monde. Plus en détail, RSC comprend 760 DGX A100, chacun avec huit A100, soit un total de 6 080 GPU. Les DGX communiquent via des liens InfiniBand à 1 600 Gb/s, soit 200 Gb/s par GPU.\r\n\r\nMais l\'entreprise estime que, d\'ici le milieu de l\'été, lorsqu\'il sera entièrement construit, il abritera quelque 16 000 GPU, devenant ainsi le superordinateur d\'IA le plus rapide au monde, avec une puissance de calcul « d’environ 5 exaflops en précision mixte ». RSC deviendrait plus puissant que Fugaku, l’actuel numéro un du TOP 500 des plus grands supercalculateurs du monde. Fugaku est un supercalculateur de l’institut de recherche japonais Riken, affichant une puissance de calcul maximale de 442010 téraflops en haute précision (64 bits), mais peut dépasser l’exaflops en précision mixte (32 ou 16 bits). RSC devrait avoir une capacité de stockage de 231 pétaoctets.\r\n\r\nLe géant des médias sociaux a refusé de commenter l\'emplacement de l\'installation ou son coût. « Pour nous, il s\'agit d\'un ordre de grandeur supérieur de calcul qui est disponible pour nos chercheurs pour former un seul modèle avec beaucoup plus de calcul que ce à quoi n\'importe qui d\'autre dans le monde a accès. Nous pensons que cela va vraiment débloquer une IA qui comprend beaucoup mieux le monde qui vous entoure », a déclaré Jerome Pesenti, vice-président de l\'IA chez Meta, dans une interview. Les critiques estiment qu\'une infrastructure HPC de cette envergure est nécessaire pour gérer le volume de données dont Facebook a besoin.\r\n\r\n« En ce qui concerne Facebook, je soupçonne que ce qu\'ils recherchent, c\'est le trésor qu\'ils ont des données qu\'ils obtiennent de leurs utilisateurs, et c\'est un énorme ensemble de données, trop grand pour la plupart des systèmes d\'intelligence artificielle que les chercheurs utilisent généralement », a déclaré Bill Gropp, directeur du National Center for Supercomputing Applications (NCSA) de l\'université de l\'Illinois à Urbana-Champaign. Toutefois, Pesenti a déclaré que le nouveau superordinateur de Meta est actuellement utilisé à des fins de recherche et il est peu probable que des produits en découlent avant des années.\r\n\r\nSelon lui, l\'objectif est d\'ingérer de grandes quantités de données pour construire des modèles d\'IA capables de penser comme un cerveau humain, avec des entrées multiples, comme la reconnaissance vocale et visuelle, et de fournir une compréhension contextuelle des situations. Plus précisément, Meta a déclaré dans le billet de blogue qu\'à terme, le nouveau supercalculateur aidera ses scientifiques à construire des modèles d\'IA capables de fonctionner dans des centaines de langues, d\'analyser à la fois des textes, des images et des vidéos et de développer des outils de réalité augmentée.\r\n', 1, '2022-01-19', '2022-03-05', 3, 2),
(5, 'Microsoft rachète Activision Blizzard', 'Activision est notamment le propriétaire des licences Call of Duty, Crash Bandicoot et Warcraft.', './public/img/2.jpeg', 'Microsoft vient d’annoncer le rachat d’Activision Blizzard, l’un des plus gros éditeurs de jeux vidéo de la planète, auteur, notamment de la série des Call of Duty. Le montant de la transaction est évalué à 70 milliards de dollars, ce qui en fait l’une des plus grosses acquisitions réalisées par Microsoft.\r\n\r\nActivision Blizzard est considéré comme l’un des plus gros éditeurs de jeux vidéo de la planète. L’acquisition permet surtout à Microsoft de mettre la main sur plusieurs studios emblématiques : les studios Treyarch, Infinity Ward, Sledgehammer et Raven Software, auteurs des Call of Duty, le studio Toys for Bob, auteur des remakes de Crash Bandicoot et Spyro, les studios Blizzard, qui ont notamment travaillé sur les séries Warcraft, Diablo et Overwatch, mais aussi les studios Beenox, High Moon et Demonware.\r\n\r\nLes studios Xbox mettent ainsi la main sur plus d’une trentaine de franchises, parmi lesquelles quelques-unes des plus emblématiques, comme les Call of Duty, Crash Bandicoot, Spyro, Tony Hawk, Diablo, Warcraft, et des licences mobiles aussi, avec notamment le très populaire Candy Crush.\r\n\r\nLe géant américain pourra proposer les futures productions Activision-Blizzard en exclusivité sur ses machines. Dans un premier temps, l’acquisition de l’éditeur permettra surtout à Microsoft d’intégrer tous les titres Activision-Blizzard à son offre Gamepass, son offre de gaming en illimité, qui compte plus de 25 millions d’abonnés.', 1, '2022-01-19', '2022-01-19', 3, 2),
(11, 'Décrocher un contrat de professionnalisation', 'Il est difficile de trouver un emploi passé 30 ans, mais rassurez-vous, ce n\'est pas impossible !', './public/img/3.jpeg', 'Lorem ipsum dolor sit amet. In eveniet laboriosam rem sequi deserunt ut laboriosam facilis rem unde amet a asperiores voluptates. Est veritatis amet non quod suscipit qui nihil quasi sed voluptas cumque sed dignissimos voluptas. Et dolore voluptas est expedita magnam rem nisi natus! Qui fugit voluptatem qui consequatur rerum eum temporibus omnis.\r\n\r\nEa laborum sint ut nihil omnis et maxime earum vel saepe assumenda et consequuntur facere et alias dolores. Qui laudantium dolores et consequatur vitae a enim similique. Et nobis officiis quo expedita velit ea ratione consequatur a tempora ullam est laborum facere quo tenetur repudiandae sed fugiat consectetur. Qui voluptas magnam sed nemo aperiam et quaerat culpa et placeat ratione qui iste reprehenderit ex galisum voluptatem.\r\n\r\nUt deserunt soluta ab tenetur numquam ad dolor alias quo beatae nostrum. Et illum rerum 33 internos molestias in voluptas inventore. Et voluptates dolores vel cumque dolores et possimus commodi eos voluptate illum est consequatur Quis. Ea voluptatem unde et inventore internos et galisum aliquam aut repellendus dolores.', 1, '2022-01-25', NULL, 6, 1),
(12, 'Les cryptomonnaies sont-elles une chaîne de Ponzi ?', 'Certains analystes continuent d’affirmer que les cryptomonnaies sont une gigantesque chaîne de Ponzi. Les cryptomonnaies ne seraient pas seulement un mauvais investissement ou une bulle spéculative. « C\'est pire que cela : c\'est une véritable fraude », déclare Sohale Andrus Mortazavi, chroniqueur spécialiste des cryptomonnaies. « Toutes les cryptomonnaies et l\'industrie dans son ensemble reposent sur la manipulation du marché, sans laquelle elles ne pourraient exister à grande échelle », affirme-t-il.', './public/img/4.jpeg', 'Certains spéculateurs vont jusqu’à dire que les cryptomonnaies peuvent mener l’humanité au chaos (dû au changement climatique). Ce serait semble-t-il possible si l\'adoption de celles reconnues énergivores comme le bitcoin se fait à des taux similaires à ceux de technologies comme les cartes de crédit. La méthode la plus courante pour produire des actifs cryptographiques nécessite d\'énormes quantités d\'électricité et génère d\'importantes émissions de dioxyde de carbone. Les producteurs d’actifs cryptographiques souhaitent utiliser davantage d\'énergie renouvelable.\r\n\r\nSelon une analyse réalisée par l’Américain Timothy Swanson, économiste spécialisé dans la gouvernance environnementale, la biodiversité, la gestion de l\'eau, ainsi que les droits de propriété intellectuelle et la réglementation des biotechnologies, le bitcoin et d’autres cryptomonnaies basés sur l\'algorithme Proof of Work sont un cauchemar suivant les critères environnementaux, sociaux et de gouvernance (ESG).\r\n\r\nPour Timothy Swanson, le concept de PoW n\'a pas été véritablement utilisé jusqu\'à ce que Satoshi Nakamoto découvre ses puissantes capacités qui ont été mises en œuvre dans le réseau du bitcoin. Pour lui, PoW serait probablement l\'idée la plus importante derrière le livre blanc Bitcoin, car elle a permis un système qui ne repose pas sur la confiance ou sur des parties individuelles pour confirmer les transactions au sein du réseau. En effet, avec le bitcoin et un certain nombre d\'autres cryptomonnaies, tous les nœuds participants (ordinateurs) ont accès au registre (blockchain), n\'importe qui peut vérifier directement les informations écrites et il n\'est pas nécessaire de faire appel à une tierce partie...', 1, '2022-01-22', NULL, 6, 4),
(13, 'L\'humanité accédera-t-elle à la vie éternelle via l\'informatique ?', 'Elon Musk, Richard Branson et Jeff Bezos se livrent à de controversées balades dans l’espace financées par les milliards dont ils sont les possesseurs. C’est l’une des éternelles obsessions du genre humain au côté d’autres comme l’accès à la vie éternelle sur laquelle le patron d’Amazon est désormais lancé. Quel rapport entre informatique et vie éternelle ? Que nous apprend le lancement des activités d’Altos Labs (et d’autres entreprises lancées dans la même filière) de Jeff Bezos sur la question ?', './public/img/5.jpeg', 'L’information au sein des cellules est de nature double : analogique (le code épigénétique) et numérique (le code génétique). De façon imagée, on peut assimiler le code génétique à l’information contenue (au film) dans les alvéoles sur un DVD et le code épigénétique à une surcouche d’informations qui recouvre les alvéoles. Les rayures sur la surface (la résultante de la biologie humaine par le biais des protéines) sont alors assimilables à du bruit et leur accumulation dans l’information analogique (la surcouche d’informations) peut impacter sur la lecture de l’information numérique (le code génétique au sein des alvéoles). C’est l’explication informatique du processus de vieillissement tirée des travaux du laboratoire David Sinclair. L’analogie permet de simplifier la compréhension des processus biologiques en œuvre dans le vieillissement.\r\n\r\nElle est le point d’ancrage des travaux de l’équipe sur la recherche d’un « correcteur au processus de vieillesse. » Le dispositif biologique permet déjà de « reprogrammer les rétines de souris et de permettre à ces dernières de regagner l’acuité visuelle de leur jeunesse. » « Pour la première fois, nous avons la possibilité d’inverser l’âge des cellules », indiquent les chercheurs. Néanmoins, des zones d’ombre demeurent : quelle est la durée de l’inversion du processus de vieillissement ? Combien de fois sera-t-il possible de répéter le processus ? Les travaux se poursuivent et l’équipe entend traiter son premier patient humain atteint de glaucome dans deux ans.', 1, '2022-01-24', NULL, 7, 4),
(14, 'Le numérique et l\'empreinte carbone de la France', 'L\'ADEME (l\'agence de la transition écologique) et l’Arcep ont publié la semaine dernière un rapport sur la part du numérique dans l\'empreinte environnementale (ou empreinte écologique) de la France. Le rapport a conclu que le numérique est responsable de 2,5 % de l’empreinte carbone de la France. Les auteurs de l\'étude notent également que des trois composantes du numérique qui constituent le périmètre de l’étude, ce sont les terminaux (et en particulier les écrans et téléviseurs) qui sont à l’origine de 65 à 90 % de l’impact environnemental.', './public/img/8.jpeg', 'En août 2020, à la demande du ministère de la Transition écologique et le ministère de l\'Économie, des Finances et de la Relance, l’ADEME et l’Arcep ont mené une mission commune de 18 mois, visant à mesurer l’empreinte environnementale numérique en France et à identifier des leviers d’actions et de bonnes pratiques pour la réduire. « S’il est souvent perçu comme positif, car créateur de croissance et de nouveaux modèles économiques, le numérique est pourtant responsable de 2,5 % de l’empreinte carbone de la France, et en forte croissance », rapporte l\'étude. Ce chiffre pourrait sembler insignifiant.\r\n\r\n\r\n\r\nMais les auteurs de l\'étude ont fait remarquer qu\'il ne cesse d’augmenter. En outre, ils précisent qu\'il n’y a aucun autre secteur où l’empreinte carbone augmente aussi rapidement, ce qui témoigne d’une dynamique très inquiétante. L\'étude consistait à : qualifier l’empreinte environnementale actuelle des réseaux fixes et mobiles, avec des projections en 2030 et 2050 ; quantifier l’empreinte environnementale du numérique sur l’ensemble du système (équipements, réseaux, centres de données) et en prenant en compte les usages des particuliers et des entreprises ; et à définir des leviers d’actions et de bonnes pratiques pour réduire cette empreinte.\r\n\r\nL\'ADEME et l’Arcep ont remis le premier rapport de leur étude au gouvernement le mercredi 19 janvier, et voici les principales conclusions de l\'étude :\r\n\r\nle numérique est responsable de 2,5 % de l’empreinte carbone de la France ;\r\ndes trois composantes du numérique qui constituent le périmètre de l’étude, ce sont les terminaux (et en particulier les écrans et téléviseurs) qui sont à l’origine de 65 à 90 % de l’impact environnemental, suivis par les centres de données (entre 4 et 22 %) et les réseaux (entre 2 et 14 %) ;\r\nparmi tous les impacts environnementaux, l’épuisement des ressources énergétiques fossiles, l’empreinte carbone, les radiations ionisantes, liés à la consommation énergétique, ainsi que l’épuisement des ressources abiotiques (minéraux et métaux) ressortent comme des impacts prédominants du numérique ;\r\nde toutes les étapes du cycle de vie des biens et services considérées, la phase de fabrication est la principale source d’impact, suivi de la phase d’utilisation, concentrant souvent à elle deux jusqu’à 100 % de l’impact environnemental.\r\n', 1, '2022-01-26', NULL, 7, 4);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT './public/img/profil.jpg',
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `email`, `password`, `photo`, `activated`, `created_at`, `isAdmin`) VALUES
(1, 'Ferry', 'Laurie', 'joypride@hotmail.fr', '$2y$10$DRa6mmKmgRdzS80MhsaF9OhJg8V8ZvmZlFiKRqFQXZ5F1tsY6f3LG', './public/img/fox.jpg', 1, '2021-12-29 10:07:19', 1),
(3, 'Testa', 'Jules', 'test@test.test', 'pomme', './public/img/profil.jpg', 1, '2022-01-12 09:29:26', 0),
(6, 'Moretti', 'Eden', 'eden@moretti.fr', '$2y$10$HES6kcF5SCxbzAR6TG9GOOEQvrHCImh1a5qOJiHgyYR2HuMqGZJzq', './public/img/profil.jpg', 1, '2022-01-23 20:22:48', 0),
(7, 'Lali', 'Lola', 'lali@lola.fr', '$2y$10$VV5WzwzSucwJ/5aPUCod7OtfDnyecBB5MSs42Sfd007D3fsq.45Kq', './public/img/profil.jpg', 1, '2022-01-23 20:26:48', 0),
(8, 'Sol', 'Anna', 'sol@anna.fr', '$2y$10$5J/VebzjkQqRDN.evevz/Oq/.zkiIkxPYgfkmBfzR6HIjMClYc4va', './public/img/profil.jpg', 1, '2022-02-06 18:44:20', 0),
(9, 'Sali', 'Azar', 'sali@azar.com', '$2y$10$Z7t6rQh.egB6Vn0GiAwq.OsfPSdgkUNARRd9VkFbg3Zq0HQdP0Y/a', './public/img/profil.jpg', 1, '2022-02-06 18:51:42', 0),
(11, 'Sartel', 'Lucas', 'lucas@sartel.com', '$2y$10$JkmbMDHidHV053sFzzLkDO3iYGlzCDwzRg7Jwg.ZbevWZww96JDBi', './public/img/profil.jpg', 1, '2022-03-02 20:12:48', 0),
(13, 'Pouilly', 'Marc', 'marc@pouilly.fr', '$2y$10$oQxgRlo7lmiAfTB7ouRfQOvrrBY4DEjwSQjpYD8kDWQQUKdQ6HZkm', './public/img/profil.jpg', 1, '2022-03-02 20:15:31', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `id_post` (`post_id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `id_category` (`category_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
