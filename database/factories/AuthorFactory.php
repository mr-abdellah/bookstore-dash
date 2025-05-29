<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        $authors = [
            [
                'name' => 'Chimamanda Ngozi Adichie',
                'bio_en' => 'Chimamanda Ngozi Adichie is a Nigerian novelist and essayist known for works like "Half of a Yellow Sun" and "Americanah." Her writing explores themes of identity, feminism, and postcolonialism.',
                'bio_fr' => 'Chimamanda Ngozi Adichie est une romancière et essayiste nigériane connue pour des œuvres comme "L’Hibiscus pourpre" et "Americanah." Ses écrits explorent l’identité, le féminisme et le postcolonialisme.',
                'bio_ar' => 'شيماماندا نغوزي أديتشي روائية وكاتبة مقالات نيجيرية معروفة بأعمال مثل "نصف شمس صفراء" و"أمريكانا". تتناول كتاباتها قضايا الهوية والنسوية وما بعد الاستعمار.'
            ],
            [
                'name' => 'Haruki Murakami',
                'bio_en' => 'Haruki Murakami is a Japanese author famous for surreal novels like "Norwegian Wood" and "Kafka on the Shore." His work blends magical realism with themes of loneliness and love.',
                'bio_fr' => 'Haruki Murakami est un auteur japonais célèbre pour ses romans surréalistes comme "La Ballade de l’impossible" et "Kafka sur le rivage." Son œuvre mêle réalisme magique, solitude et amour.',
                'bio_ar' => 'هاروكي موراكامي كاتب ياباني شهير برواياته السريالية مثل "غابة النرويج" و"كافكا على الشاطئ". يمزج أعماله بين الواقعية السحرية وموضوعات الوحدة والحب.'
            ],
            [
                'name' => 'Toni Morrison',
                'bio_en' => 'Toni Morrison was an American novelist and Nobel laureate, celebrated for "Beloved" and "Song of Solomon." Her work delves into African American history and identity.',
                'bio_fr' => 'Toni Morrison était une romancière américaine et lauréate du Nobel, célèbre pour "Beloved" et "Le Chant de Salomon." Son œuvre explore l’histoire et l’identité afro-américaines.',
                'bio_ar' => 'توني موريسون كانت روائية أمريكية وحائزة على جائزة نوبل، اشتهرت بـ"محبوبة" و"أغنية سليمان". تتناول أعمالها تاريخ وهوية الأمريكيين الأفارقة.'
            ],
            [
                'name' => 'Gabriel García Márquez',
                'bio_en' => 'Gabriel García Márquez was a Colombian novelist and Nobel laureate, known for "One Hundred Years of Solitude." He pioneered magical realism in Latin American literature.',
                'bio_fr' => 'Gabriel García Márquez était un romancier colombien et lauréat du Nobel, connu pour "Cent ans de solitude." Il a été pionnier du réalisme magique en littérature latino-américaine.',
                'bio_ar' => 'غابرييل غارسيا ماركيز كان روائيًا كولومبيًا وحائزًا على جائزة نوبل، اشتهر بـ"مئة عام من العزلة". كان رائدًا في الواقعية السحرية في الأدب اللاتيني الأمريكي.'
            ],
            [
                'name' => 'Khaled Hosseini',
                'bio_en' => 'Khaled Hosseini is an Afghan-American author of "The Kite Runner" and "A Thousand Splendid Suns." His novels explore family, exile, and Afghan culture.',
                'bio_fr' => 'Khaled Hosseini est un auteur afghano-américain de "Les Cerfs-volants de Kaboul" et "Mille soleils splendides." Ses romans explorent la famille, l’exil et la culture afghane.',
                'bio_ar' => 'خالد حسيني كاتب أفغاني-أمريكي، مؤلف "عداء الطائرة الورقية" و"ألف شمس مشرقة". تتناول رواياته العائلة، المنفى، والثقافة الأفغانية.'
            ],
            [
                'name' => 'Margaret Atwood',
                'bio_en' => 'Margaret Atwood is a Canadian author known for "The Handmaid’s Tale" and "Alias Grace." Her work often tackles feminism, dystopia, and power dynamics.',
                'bio_fr' => 'Margaret Atwood est une auteure canadienne connue pour "La Servante écarlate" et "Alias Grace." Ses œuvres abordent souvent le féminisme, la dystopie et les dynamiques de pouvoir.',
                'bio_ar' => 'مارغريت أتوود كاتبة كندية معروفة بـ"حكاية الخادمة" و"ألياس غريس". تتناول أعمالها غالبًا النسوية، الديستوبيا، وديناميكيات القوة.'
            ],
            [
                'name' => 'Orhan Pamuk',
                'bio_en' => 'Orhan Pamuk is a Turkish novelist and Nobel laureate, known for "My Name is Red" and "Snow." His work blends history, identity, and Turkish culture.',
                'bio_fr' => 'Orhan Pamuk est un romancier turc et lauréat du Nobel, connu pour "Mon nom est Rouge" et "Neige." Son œuvre mêle histoire, identité et culture turque.',
                'bio_ar' => 'أورهان باموق روائي تركي وحائز على جائزة نوبل، معروف بـ"اسمي أحمر" و"ثلج". يمزج أعماله بين التاريخ، الهوية، والثقافة التركية.'
            ],
            [
                'name' => 'Isabel Allende',
                'bio_en' => 'Isabel Allende is a Chilean author known for "The House of the Spirits" and "City of the Beasts." Her work often features magical realism and Latin American themes.',
                'bio_fr' => 'Isabel Allende est une auteure chilienne connue pour "La Maison aux esprits" et "La Cité des bêtes." Ses œuvres intègrent souvent le réalisme magique et des thèmes latino-américains.',
                'bio_ar' => 'إيزابيل أليندي كاتبة تشيلية معروفة بـ"بيت الأرواح" و"مدينة الوحوش". غالبًا ما تتضمن أعمالها الواقعية السحرية وموضوعات أمريكا اللاتينية.'
            ],
            [
                'name' => 'Ngũgĩ wa Thiong’o',
                'bio_en' => 'Ngũgĩ wa Thiong’o is a Kenyan author known for "A Grain of Wheat" and "Decolonising the Mind." His work focuses on African identity and postcolonial struggles.',
                'bio_fr' => 'Ngũgĩ wa Thiong’o est un auteur kényan connu pour "Un grain de blé" et "Décoloniser l’esprit." Son œuvre se concentre sur l’identité africaine et les luttes postcoloniales.',
                'bio_ar' => 'نغوغي وا ثيونغو كاتب كيني معروف بـ"حبة قمح" و"إنهاء استعمار العقل". تركز أعماله على الهوية الأفريقية والصراعات ما بعد الاستعمار.'
            ],
            [
                'name' => 'Jhumpa Lahiri',
                'bio_en' => 'Jhumpa Lahiri is an American author of Indian descent, known for "Interpreter of Maladies" and "The Namesake." Her work explores immigration and identity.',
                'bio_fr' => 'Jhumpa Lahiri est une auteure américaine d’origine indienne, connue pour "L’Interprète des maladies" et "Un nom pour un autre." Ses œuvres explorent l’immigration et l’identité.',
                'bio_ar' => 'جهومبا لاهيري كاتبة أمريكية من أصل هندي، معروفة بـ"مترجم الأمراض" و"الاسم نفسه". تتناول أعمالها الهجرة والهوية.'
            ],
            [
                'name' => 'Yu Hua',
                'bio_en' => 'Yu Hua is a Chinese author known for "To Live" and "Chronicle of a Blood Merchant." His novels depict modern Chinese history and human resilience.',
                'bio_fr' => 'Yu Hua est un auteur chinois connu pour "Vivre !" et "Chronique d’un marchand de sang." Ses romans dépeignent l’histoire chinoise moderne et la résilience humaine.',
                'bio_ar' => 'يو هوا كاتب صيني معروف بـ"للعيش" و"سجل تاجر الدم". تصور رواياته التاريخ الصيني الحديث والصمود البشري.'
            ],
            [
                'name' => 'Elena Ferrante',
                'bio_en' => 'Elena Ferrante is the pseudonym of an Italian novelist known for the Neapolitan Novels, including "My Brilliant Friend." Her work explores friendship and social class.',
                'bio_fr' => 'Elena Ferrante est le pseudonyme d’une romancière italienne connue pour les romans napolitains, dont "L’Amie prodigieuse." Son œuvre explore l’amitié et les classes sociales.',
                'bio_ar' => 'إيلينا فيرانتي هو الاسم المستعار لروائية إيطالية معروفة بالروايات النابولية، بما في ذلك "صديقتي المذهلة". تتناول أعمالها الصداقة والطبقات الاجتماعية.'
            ],
            [
                'name' => 'Zadie Smith',
                'bio_en' => 'Zadie Smith is a British novelist known for "White Teeth" and "On Beauty." Her work examines race, identity, and multiculturalism in modern society.',
                'bio_fr' => 'Zadie Smith est une romancière britannique connue pour "Sourires de loup" et "De la beauté." Son œuvre examine la race, l’identité et le multiculturalisme dans la société moderne.',
                'bio_ar' => 'زادي سميث روائية بريطانية معروفة بـ"أسنان بيضاء" و"عن الجمال". تتناول أعمالها العرق، الهوية، والتعددية الثقافية في المجتمع الحديث.'
            ],
            [
                'name' => 'Arundhati Roy',
                'bio_en' => 'Arundhati Roy is an Indian author known for "The God of Small Things." Her work blends lyrical prose with themes of caste, family, and Indian society.',
                'bio_fr' => 'Arundhati Roy est une auteure indienne connue pour "Le Dieu des petites choses." Son œuvre mêle prose lyrique et thèmes de caste, famille et société indienne.',
                'bio_ar' => 'أرونداتي روي كاتبة هندية معروفة بـ"إله الأشياء الصغيرة". تمزج أعمالها بين النثر الشاعري وموضوعات الطبقية، العائلة، والمجتمع الهندي.'
            ],
            [
                'name' => 'Kazuo Ishiguro',
                'bio_en' => 'Kazuo Ishiguro is a British novelist and Nobel laureate, known for "Never Let Me Go" and "The Remains of the Day." His work explores memory and human connection.',
                'bio_fr' => 'Kazuo Ishiguro est un romancier britannique et lauréat du Nobel, connu pour "Auprès de moi toujours" et "Les Vestiges du jour." Son œuvre explore la mémoire et les liens humains.',
                'bio_ar' => 'كازو إيشيغورو روائي بريطاني وحائز على جائزة نوبل، معروف بـ"لا تتركني أبدًا" و"بقايا اليوم". تتناول أعمالها الذاكرة والارتباط البشري.'
            ],
            [
                'name' => 'Naguib Mahfouz',
                'bio_en' => 'Naguib Mahfouz was an Egyptian novelist and Nobel laureate, known for "The Cairo Trilogy." His work captures Egyptian society and human struggles.',
                'bio_fr' => 'Naguib Mahfouz était un romancier égyptien et lauréat du Nobel, connu pour "La Trilogie du Caire." Son œuvre capture la société égyptienne et les luttes humaines.',
                'bio_ar' => 'نجيب محفوظ كان روائيًا مصريًا وحائزًا على جائزة نوبل، معروف بـ"ثلاثية القاهرة". تصور أعماله المجتمع المصري والصراعات البشرية.'
            ],
            [
                'name' => 'Colson Whitehead',
                'bio_en' => 'Colson Whitehead is an American author known for "The Underground Railroad" and "The Nickel Boys." His work addresses race and American history.',
                'bio_fr' => 'Colson Whitehead est un auteur américain connu pour "Underground Railroad" et "Nickel Boys." Son œuvre aborde la race et l’histoire américaine.',
                'bio_ar' => 'كولسون وايتهيد كاتب أمريكي معروف بـ"السكة الحديدية تحت الأرض" و"أولاد النيكل". تتناول أعماله العرق والتاريخ الأمريكي.'
            ],
            [
                'name' => 'Hilary Mantel',
                'bio_en' => 'Hilary Mantel was a British author known for the "Wolf Hall" trilogy. Her historical novels explore power and Tudor England.',
                'bio_fr' => 'Hilary Mantel était une auteure britannique connue pour la trilogie "Wolf Hall." Ses romans historiques explorent le pouvoir et l’Angleterre des Tudor.',
                'bio_ar' => 'هيلاري مانتل كانت كاتبة بريطانية معروفة بثلاثية "وولف هول". تستكشف رواياتها التاريخية السلطة وإنجلترا التيودورية.'
            ],
            [
                'name' => 'Ocean Vuong',
                'bio_en' => 'Ocean Vuong is a Vietnamese-American poet and novelist, known for "On Earth We’re Briefly Gorgeous." His work explores identity, family, and queerness.',
                'bio_fr' => 'Ocean Vuong est un poète et romancier vietnamo-américain, connu pour "Un bref instant de splendeur." Son œuvre explore l’identité, la famille et la queerness.',
                'bio_ar' => 'أوشن فونغ شاعر وروائي فيتنامي-أمريكي، معروف بـ"على الأرض نحن رائعون للحظة". تتناول أعماله الهوية، العائلة، والمثلية.'
            ],
            [
                'name' => 'Chinua Achebe',
                'bio_en' => 'Chinua Achebe was a Nigerian novelist known for "Things Fall Apart." His work examines African traditions and the impact of colonialism.',
                'bio_fr' => 'Chinua Achebe était un romancier nigérian connu pour "Tout s’effondre." Son œuvre examine les traditions africaines et l’impact du colonialisme.',
                'bio_ar' => 'تشينوا أتشيبي كان روائيًا نيجيريًا معروفًا بـ"الأشياء تتداعى". تتناول أعماله التقاليد الأفريقية وتأثير الاستعمار.'
            ],
            [
                'name' => 'Doris Lessing',
                'bio_en' => 'Doris Lessing was a British-Zimbabwean novelist and Nobel laureate, known for "The Golden Notebook." Her work explores feminism and social issues.',
                'bio_fr' => 'Doris Lessing était une romancière britanno-zimbabwéenne et lauréate du Nobel, connue pour "Le Carnet d’or." Son œuvre explore le féminisme et les problèmes sociaux.',
                'bio_ar' => 'دوريس ليسينغ كانت روائية بريطانية-زيمبابوية وحائزة على جائزة نوبل، معروفة بـ"الدفتر الذهبي". تتناول أعمالها النسوية والقضايا الاجتماعية.'
            ],
            [
                'name' => 'José Saramago',
                'bio_en' => 'José Saramago was a Portuguese novelist and Nobel laureate, known for "Blindness." His work blends allegory with social commentary.',
                'bio_fr' => 'José Saramago était un romancier portugais et lauréat du Nobel, connu pour "L’Aveuglement." Son œuvre mêle allégorie et commentaire social.',
                'bio_ar' => 'جوزيه ساراماغو كان روائيًا برتغاليًا وحائزًا على جائزة نوبل، معروف بـ"العمى". يمزج أعماله بين الرمزية والتعليق الاجتماعي.'
            ],
            [
                'name' => 'Tayeb Salih',
                'bio_en' => 'Tayeb Salih was a Sudanese novelist known for "Season of Migration to the North." His work explores postcolonial identity and cultural conflict.',
                'bio_fr' => 'Tayeb Salih était un romancier soudanais connu pour "Saison de migration vers le nord." Son œuvre explore l’identité postcoloniale et les conflits culturels.',
                'bio_ar' => 'الطيب صالح كان روائيًا سودانيًا معروفًا بـ"موسم الهجرة إلى الشمال". تتناول أعماله الهوية ما بعد الاستعمار والصراع الثقافي.'
            ],
            [
                'name' => 'Banana Yoshimoto',
                'bio_en' => 'Banana Yoshimoto is a Japanese author known for "Kitchen." Her minimalist novels explore love, loss, and contemporary Japanese life.',
                'bio_fr' => 'Banana Yoshimoto est une auteure japonaise connue pour "Kitchen." Ses romans minimalistes explorent l’amour, la perte et la vie japonaise contemporaine.',
                'bio_ar' => 'بانانا يوشيموتو كاتبة يابانية معروفة بـ"المطبخ". تستكشف رواياتها البسيطة الحب، الخسارة، والحياة اليابانية المعاصرة.'
            ],
            [
                'name' => 'Vikram Seth',
                'bio_en' => 'Vikram Seth is an Indian author known for "A Suitable Boy." His work spans poetry and prose, exploring Indian culture and relationships.',
                'bio_fr' => 'Vikram Seth est un auteur indien connu pour "Un garçon convenable." Son œuvre couvre la poésie et la prose, explorant la culture indienne et les relations.',
                'bio_ar' => 'فيكرام سيث كاتب هندي معروف بـ"فتى مناسب". تمتد أعماله بين الشعر والنثر، مستكشفة الثقافة الهندية والعلاقات.'
            ],
            [
                'name' => 'Edwidge Danticat',
                'bio_en' => 'Edwidge Danticat is a Haitian-American author known for "Breath, Eyes, Memory." Her work explores Haitian diaspora and family ties.',
                'bio_fr' => 'Edwidge Danticat est une auteure haïtiano-américaine connue pour "Le Cri de l’oiseau rouge." Son œuvre explore la diaspora haïtienne et les liens familiaux.',
                'bio_ar' => 'إدويدج دانتيكات كاتبة هايتية-أمريكية معروفة بـ"نفس، عيون، ذاكرة". تتناول أعمالها الشتات الهايتي والروابط العائلية.'
            ],
            [
                'name' => 'Mo Yan',
                'bio_en' => 'Mo Yan is a Chinese novelist and Nobel laureate, known for "Red Sorghum." His work blends folklore with modern Chinese history.',
                'bio_fr' => 'Mo Yan est un romancier chinois et lauréat du Nobel, connu pour "Le Clan du sorgho rouge." Son œuvre mêle folklore et histoire chinoise moderne.',
                'bio_ar' => 'مو يان روائي صيني وحائز على جائزة نوبل، معروف بـ"الذرة الحمراء". يمزج أعماله بين الفلكلور والتاريخ الصيني الحديث.'
            ],
            [
                'name' => 'Amin Maalouf',
                'bio_en' => 'Amin Maalouf is a Lebanese-French author known for "The Rock of Tanios." His work explores history, identity, and the Mediterranean world.',
                'bio_fr' => 'Amin Maalouf est un auteur libano-français connu pour "Le Rocher de Tanios." Son œuvre explore l’histoire, l’identité et le monde méditerranéen.',
                'bio_ar' => 'أمين معلوف كاتب لبناني-فرنسي معروف بـ"صخرة طانيوس". تتناول أعماله التاريخ، الهوية، والعالم المتوسطي.'
            ],
            [
                'name' => 'Ben Okri',
                'bio_en' => 'Ben Okri is a Nigerian-British author known for "The Famished Road." His work blends African mythology with postcolonial themes.',
                'bio_fr' => 'Ben Okri est un auteur nigérian-britannique connu pour "La Route affamée." Son œuvre mêle mythologie africaine et thèmes postcoloniaux.',
                'bio_ar' => 'بن أوكري كاتب نيجيري-بريطاني معروف بـ"الطريق الجائع". يمزج أعماله بين الأساطير الأفريقية وموضوعات ما بعد الاستعمار.'
            ],
            [
                'name' => 'Yaa Gyasi',
                'bio_en' => 'Yaa Gyasi is a Ghanaian-American author known for "Homegoing." Her work traces African diaspora and intergenerational trauma.',
                'bio_fr' => 'Yaa Gyasi est une auteure ghanéenne-américaine connue pour "No home." Son œuvre retrace la diaspora africaine et les traumatismes intergénérationnels.',
                'bio_ar' => 'يا جياسي كاتبة غانية-أمريكية معروفة بـ"العودة إلى الوطن". تتتبع أعمالها الشتات الأفريقي والصدمات بين الأجيال.'
            ],
            [
                'name' => 'Anita Desai',
                'bio_en' => 'Anita Desai is an Indian author known for "Clear Light of Day." Her work explores family dynamics and Indian society.',
                'bio_fr' => 'Anita Desai est une auteure indienne connue pour "Clair-obscur." Son œuvre explore les dynamiques familiales et la société indienne.',
                'bio_ar' => 'أنيتا ديساي كاتبة هندية معروفة بـ"ضوء النهار الصافي". تتناول أعمالها ديناميكيات العائلة والمجتمع الهندي.'
            ],
            [
                'name' => 'Herta Müller',
                'bio_en' => 'Herta Müller is a Romanian-German novelist and Nobel laureate, known for "The Land of Green Plums." Her work addresses oppression and exile.',
                'bio_fr' => 'Herta Müller est une romancière roumano-allemande et lauréate du Nobel, connue pour "Le Pays des prunes vertes." Son œuvre traite de l’oppression et de l’exil.',
                'bio_ar' => 'هيرتا مولر روائية رومانية-ألمانية وحائزة على جائزة نوبل، معروفة بـ"أرض الخوخ الأخضر". تتناول أعمالها القمع والمنفى.'
            ],
            [
                'name' => 'C Pam Zhang',
                'bio_en' => 'C Pam Zhang is an American author known for "How Much of These Hills Is Gold." Her work reimagines the American West and immigrant experiences.',
                'bio_fr' => 'C Pam Zhang est une auteure américaine connue pour "Combien de ces collines sont en or." Son œuvre réinvente l’Ouest américain et les expériences des immigrants.',
                'bio_ar' => 'سي بام تشانغ كاتبة أمريكية معروفة بـ"كم من هذه التلال ذهب". تعيد أعمالها تصور الغرب الأمريكي وتجارب المهاجرين.'
            ],
            [
                'name' => 'Leila Slimani',
                'bio_en' => 'Leila Slimani is a Moroccan-French author known for "Lullaby." Her work explores motherhood, class, and Moroccan identity.',
                'bio_fr' => 'Leila Slimani est une auteure maroco-française connue pour "Chanson douce." Son œuvre explore la maternité, la classe et l’identité marocaine.',
                'bio_ar' => 'ليلى سليماني كاتبة مغربية-فرنسية معروفة بـ"أغنية هادئة". تتناول أعمالها الأمومة، الطبقة، والهوية المغربية.'
            ],
            [
                'name' => 'J.M. Coetzee',
                'bio_en' => 'J.M. Coetzee is a South African-Australian novelist and Nobel laureate, known for "Disgrace." His work examines morality and postcolonial South Africa.',
                'bio_fr' => 'J.M. Coetzee est un romancier sud-africain-australien et lauréat du Nobel, connu pour "Disgrâce." Son œuvre examine la moralité et l’Afrique du Sud postcoloniale.',
                'bio_ar' => 'ج.م. كويتزي روائي جنوب أفريقي-أسترالي وحائز على جائزة نوبل، معروف بـ"العار". تتناول أعماله الأخلاق وجنوب أفريقيا ما بعد الاستعمار.'
            ],
            [
                'name' => 'Kenzaburō Ōe',
                'bio_en' => 'Kenzaburō Ōe is a Japanese novelist and Nobel laureate, known for "A Personal Matter." His work explores family and post-war Japan.',
                'bio_fr' => 'Kenzaburō Ōe est un romancier japonais et lauréat du Nobel, connu pour "Une affaire personnelle." Son œuvre explore la famille et le Japon d’après-guerre.',
                'bio_ar' => 'كنزابورو أوي روائي ياباني وحائز على جائزة نوبل، معروف بـ"مسألة شخصية". تتناول أعماله العائلة واليابان بعد الحرب.'
            ],
            [
                'name' => 'Marjane Satrapi',
                'bio_en' => 'Marjane Satrapi is an Iranian-French author known for "Persepolis." Her graphic memoirs explore identity and the Iranian Revolution.',
                'bio_fr' => 'Marjane Satrapi est une auteure irano-française connue pour "Persepolis." Ses mémoires graphiques explorent l’identité et la révolution iranienne.',
                'bio_ar' => 'مرجان ساتراپي كاتبة إيرانية-فرنسية معروفة بـ"برسيبوليس". تستكشف مذكراتها المصورة الهوية والثورة الإيرانية.'
            ]
        ];

        // Randomly select an author
        $author = $this->faker->randomElement($authors);

        return [
            'id' => Str::uuid()->toString(),
            'name' => $author['name'],
            'bio' => $author['bio_ar'],
            // 'bio_fr' => $author['bio_fr'],
            // 'bio_ar' => $author['bio_ar'],
            'avatar' => $this->faker->imageUrl(200, 200, 'people'),
        ];
    }
}