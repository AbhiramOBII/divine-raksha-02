<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $spirituality = BlogCategory::create([
            'title' => 'Spirituality',
            'short_description' => 'Explore the depths of spiritual wisdom and practices',
            'full_description' => '<p>Dive into articles about meditation, mantras, divine energy, and the spiritual traditions of Sanatana Dharma.</p>',
            'status' => true,
        ]);

        $rudraksha = BlogCategory::create([
            'title' => 'Rudraksha',
            'short_description' => 'Everything about the sacred Rudraksha beads',
            'full_description' => '<p>Learn about the different mukhi Rudraksha, their significance, benefits, and how to identify authentic beads.</p>',
            'status' => true,
        ]);

        $wellness = BlogCategory::create([
            'title' => 'Wellness & Healing',
            'short_description' => 'Holistic wellness through ancient Indian practices',
            'full_description' => '<p>Articles on holistic health, energy healing, chakra balancing, and the science behind spiritual wellness practices.</p>',
            'status' => true,
        ]);

        $lifestyle = BlogCategory::create([
            'title' => 'Sacred Lifestyle',
            'short_description' => 'Incorporating spirituality into everyday life',
            'full_description' => '<p>Practical tips on bringing sacred rituals, mindful living, and spiritual discipline into your modern daily routine.</p>',
            'status' => true,
        ]);

        // Spirituality blogs
        Blog::create([
            'category_id' => $spirituality->id,
            'title' => 'The Power of Om: Understanding the Sacred Sound',
            'short_description' => 'Discover why Om is considered the primordial sound of the universe and how chanting it can transform your spiritual practice.',
            'full_description' => '<h2>The Universal Vibration</h2><p>Om (ॐ) is not merely a word or a syllable — it is the vibrational essence of the entire cosmos. In the ancient Vedic tradition, Om is considered the first sound that emerged at the time of creation, the primordial vibration from which all existence flows.</p><h2>The Science Behind the Sound</h2><p>Modern scientific studies have shown that chanting Om produces a vibrational frequency of 432 Hz, which is the same frequency found in nature. This resonance creates a calming effect on the nervous system, reduces stress hormones, and promotes a deep state of relaxation and mental clarity.</p><h2>How to Practice Om Chanting</h2><p>Find a quiet, clean space. Sit comfortably with your spine straight. Close your eyes and take a few deep breaths. Begin chanting Om slowly, allowing the sound to resonate from your navel, through your chest, and out through your lips. Feel the vibration in every cell of your body.</p><p>Start with 11 repetitions and gradually increase to 108 — the sacred number in Hindu tradition. Many practitioners use a Rudraksha mala to count their chants, as the beads themselves carry spiritual energy that amplifies the practice.</p><h2>Benefits of Regular Practice</h2><ul><li>Calms the mind and reduces anxiety</li><li>Improves concentration and focus</li><li>Strengthens spiritual connection</li><li>Balances the chakra system</li><li>Creates positive energy in your environment</li></ul>',
            'meta_title' => 'The Power of Om Chanting - Spiritual Benefits & Practice Guide',
            'meta_description' => 'Learn about the sacred sound Om, its significance in Vedic tradition, scientific benefits, and how to incorporate Om chanting into your daily spiritual practice.',
            'status' => true,
        ]);

        Blog::create([
            'category_id' => $spirituality->id,
            'title' => '5 Morning Rituals to Start Your Day with Divine Energy',
            'short_description' => 'Simple yet powerful morning spiritual practices that can set a positive tone for your entire day.',
            'full_description' => '<h2>Begin Each Day with Intention</h2><p>In the Vedic tradition, the early morning hours — known as Brahma Muhurta (approximately 4:00 AM to 5:30 AM) — are considered the most auspicious time for spiritual practice. The atmosphere is calm, the mind is fresh, and divine energy is at its peak.</p><h2>1. Gratitude Prayer Upon Waking</h2><p>Before your feet touch the ground, take a moment to offer gratitude. Place your palms together and recite a simple prayer of thanks for the new day, for your health, and for the blessings in your life.</p><h2>2. Light a Diya or Incense</h2><p>Lighting a small oil lamp or incense stick creates a sacred atmosphere in your home. The flame represents the presence of the divine, while incense purifies the space and uplifts the energy around you.</p><h2>3. Chant a Mantra</h2><p>Choose a mantra that resonates with you — it could be the Gayatri Mantra, Om Namah Shivaya, or simply Om. Chant it 11, 21, or 108 times using a mala. This practice centres your mind and connects you with higher consciousness.</p><h2>4. Meditate for 10 Minutes</h2><p>Sit quietly and focus on your breath. Allow thoughts to come and go without attachment. Even 10 minutes of morning meditation can dramatically reduce stress and improve your emotional resilience throughout the day.</p><h2>5. Set a Sankalpa (Intention)</h2><p>A Sankalpa is a heartfelt intention or resolve. State clearly what you wish to cultivate today — patience, kindness, focus, or courage. Carry this intention with you as you move through your day.</p>',
            'meta_title' => '5 Morning Spiritual Rituals for a Blessed Day',
            'meta_description' => 'Discover 5 powerful morning rituals rooted in Vedic tradition to start your day with divine energy, positivity, and spiritual focus.',
            'status' => true,
        ]);

        // Rudraksha blogs
        Blog::create([
            'category_id' => $rudraksha->id,
            'title' => 'Rudraksha Beads: A Complete Guide for Beginners',
            'short_description' => 'Everything you need to know about Rudraksha — from identifying authentic beads to understanding the significance of different mukhis.',
            'full_description' => '<h2>What is Rudraksha?</h2><p>Rudraksha beads are the seeds of the Elaeocarpus ganitrus tree, primarily found in the Himalayan regions of Nepal, Indonesia, and parts of South India. The word "Rudraksha" is derived from two Sanskrit words: "Rudra" (a name for Lord Shiva) and "Aksha" (meaning eyes or tears). Legend holds that these sacred beads originated from the tears of Lord Shiva during deep meditation.</p><h2>Understanding Mukhis (Faces)</h2><p>Each Rudraksha bead has natural lines or clefts running from top to bottom, called "mukhis" or faces. The number of mukhis determines the bead\'s properties and ruling deity:</p><ul><li><strong>1 Mukhi:</strong> Represents Lord Shiva — for enlightenment and detachment</li><li><strong>2 Mukhi:</strong> Represents Ardhanarishvara — for harmony in relationships</li><li><strong>3 Mukhi:</strong> Represents Agni Dev — for confidence and self-esteem</li><li><strong>4 Mukhi:</strong> Represents Lord Brahma — for knowledge and creativity</li><li><strong>5 Mukhi:</strong> Represents Kalagni Rudra — the most common, for general well-being</li><li><strong>6 Mukhi:</strong> Represents Lord Kartikeya — for willpower and focus</li><li><strong>7 Mukhi:</strong> Represents Goddess Lakshmi — for prosperity and abundance</li></ul><h2>How to Identify Authentic Rudraksha</h2><p>An authentic Rudraksha will sink in water, have natural and well-defined mukhis, and feel slightly rough to the touch. Avoid beads that are perfectly smooth, artificially coloured, or suspiciously cheap. At Divine Raksha, every bead is carefully verified for authenticity before listing.</p><h2>How to Wear and Care</h2><p>Rudraksha can be worn as a mala around the neck or as a bracelet on the wrist. Before wearing for the first time, wash with clean water, offer a prayer, and chant "Om Namah Shivaya." Oil your beads regularly with sesame or coconut oil to maintain their lustre.</p>',
            'meta_title' => 'Complete Rudraksha Guide - Types, Benefits & How to Wear',
            'meta_description' => 'A comprehensive beginner\'s guide to Rudraksha beads — learn about mukhis, spiritual benefits, authenticity checks, and proper care instructions.',
            'status' => true,
        ]);

        Blog::create([
            'category_id' => $rudraksha->id,
            'title' => 'How to Choose the Right Rudraksha Based on Your Zodiac Sign',
            'short_description' => 'Find out which Rudraksha mukhi aligns with your zodiac sign and planetary influences for maximum spiritual benefit.',
            'full_description' => '<h2>Rudraksha and Vedic Astrology</h2><p>In Vedic astrology, each planet governs specific aspects of life, and each Rudraksha mukhi is associated with a particular planetary energy. Wearing the right Rudraksha can help balance planetary influences and enhance positive energies in your life.</p><h2>Zodiac-Based Recommendations</h2><ul><li><strong>Aries (Mesh):</strong> 3 Mukhi Rudraksha — ruled by Mars, boosts courage and confidence</li><li><strong>Taurus (Vrishabh):</strong> 6 Mukhi Rudraksha — ruled by Venus, enhances creativity and relationships</li><li><strong>Gemini (Mithun):</strong> 4 Mukhi Rudraksha — ruled by Mercury, improves communication and intellect</li><li><strong>Cancer (Kark):</strong> 2 Mukhi Rudraksha — ruled by Moon, brings emotional balance</li><li><strong>Leo (Simha):</strong> 1 or 12 Mukhi Rudraksha — ruled by Sun, enhances leadership qualities</li><li><strong>Virgo (Kanya):</strong> 4 Mukhi Rudraksha — ruled by Mercury, sharpens analytical thinking</li><li><strong>Libra (Tula):</strong> 6 Mukhi Rudraksha — ruled by Venus, promotes harmony and beauty</li><li><strong>Scorpio (Vrishchik):</strong> 3 Mukhi Rudraksha — ruled by Mars, strengthens willpower</li><li><strong>Sagittarius (Dhanu):</strong> 5 Mukhi Rudraksha — ruled by Jupiter, enhances wisdom</li><li><strong>Capricorn (Makar):</strong> 7 Mukhi Rudraksha — ruled by Saturn, brings discipline and prosperity</li><li><strong>Aquarius (Kumbh):</strong> 7 Mukhi Rudraksha — ruled by Saturn, promotes service and detachment</li><li><strong>Pisces (Meen):</strong> 5 Mukhi Rudraksha — ruled by Jupiter, deepens spiritual connection</li></ul><h2>A Word of Guidance</h2><p>While zodiac-based selection is a helpful starting point, the most important factor is your personal intention and faith. Any Rudraksha worn with devotion and positive intent will bring benefits. If unsure, the 5 Mukhi Rudraksha is universally recommended and suitable for everyone.</p>',
            'meta_title' => 'Best Rudraksha for Your Zodiac Sign - Vedic Astrology Guide',
            'meta_description' => 'Discover which Rudraksha mukhi is best suited for your zodiac sign based on Vedic astrology for enhanced spiritual and planetary balance.',
            'status' => true,
        ]);

        // Wellness blogs
        Blog::create([
            'category_id' => $wellness->id,
            'title' => 'Understanding the 7 Chakras and How to Balance Them',
            'short_description' => 'A guide to the seven energy centres in your body and practical ways to keep them aligned for holistic well-being.',
            'full_description' => '<h2>What Are Chakras?</h2><p>Chakras are energy centres located along the spine, from the base to the crown of the head. The word "chakra" comes from Sanskrit, meaning "wheel" or "circle." These spinning wheels of energy correspond to specific organs, emotions, and aspects of consciousness.</p><h2>The Seven Chakras</h2><ul><li><strong>Root Chakra (Muladhara):</strong> Base of spine — governs stability, security, and grounding. Colour: Red.</li><li><strong>Sacral Chakra (Svadhisthana):</strong> Below navel — governs creativity, emotions, and pleasure. Colour: Orange.</li><li><strong>Solar Plexus Chakra (Manipura):</strong> Stomach area — governs confidence, willpower, and personal power. Colour: Yellow.</li><li><strong>Heart Chakra (Anahata):</strong> Centre of chest — governs love, compassion, and forgiveness. Colour: Green.</li><li><strong>Throat Chakra (Vishuddha):</strong> Throat — governs communication, truth, and self-expression. Colour: Blue.</li><li><strong>Third Eye Chakra (Ajna):</strong> Between eyebrows — governs intuition, wisdom, and spiritual insight. Colour: Indigo.</li><li><strong>Crown Chakra (Sahasrara):</strong> Top of head — governs divine connection, enlightenment, and universal consciousness. Colour: Violet/White.</li></ul><h2>Simple Balancing Practices</h2><p>Regular meditation, wearing specific gemstones or Rudraksha beads, practising yoga asanas, chanting seed mantras (Lam, Vam, Ram, Yam, Ham, Om, Silence), and spending time in nature can all help keep your chakras balanced and energy flowing freely.</p>',
            'meta_title' => '7 Chakras Explained - Guide to Balancing Your Energy Centres',
            'meta_description' => 'Learn about the 7 chakras, their significance, and practical techniques to balance your energy centres for holistic physical and spiritual wellness.',
            'status' => true,
        ]);

        Blog::create([
            'category_id' => $wellness->id,
            'title' => 'The Healing Power of Karungali Wood in Tamil Spiritual Tradition',
            'short_description' => 'Explore the deep-rooted significance of Karungali (Ebony) wood in South Indian spiritual practices and its believed healing properties.',
            'full_description' => '<h2>What is Karungali?</h2><p>Karungali, known as Ebony wood (Diospyros ebenum), is a dense, dark-coloured wood that has been revered in Tamil and South Indian spiritual traditions for centuries. The name "Karungali" literally translates to "black wood" in Tamil, and it holds a sacred place in Hindu worship and spiritual practice.</p><h2>Spiritual Significance</h2><p>In Tamil spiritual tradition, Karungali is associated with Lord Shani (Saturn) and is believed to possess powerful protective and grounding energies. Devotees believe that wearing Karungali malas or keeping Karungali items in the home can help ward off negative energies, neutralise the effects of Shani dosha, and bring stability to one\'s life.</p><h2>Believed Benefits</h2><ul><li>Protection from negative energies and evil eye</li><li>Grounding and emotional stability</li><li>Relief from effects of Shani dosha in one\'s horoscope</li><li>Improved focus during meditation and prayer</li><li>Creates a positive and sacred atmosphere in living spaces</li></ul><h2>How to Use Karungali</h2><p>Karungali malas are traditionally made with 108 beads and are used for japa (chanting) meditation. They can also be worn as a necklace or bracelet for daily protection. Some families keep a small Karungali idol or piece of wood near their home altar for positive energy.</p><p>At Divine Raksha, our Karungali malas are crafted from genuine ebony wood, carefully shaped and strung with traditional bead counts to honour the sacred significance of this beautiful material.</p>',
            'meta_title' => 'Karungali Wood - Spiritual Significance & Healing Properties',
            'meta_description' => 'Explore the sacred Karungali (Ebony) wood in Tamil spiritual tradition — its significance, believed healing benefits, and how to use it for spiritual protection.',
            'status' => true,
        ]);

        // Sacred Lifestyle blogs
        Blog::create([
            'category_id' => $lifestyle->id,
            'title' => 'How to Create a Sacred Space in Your Home',
            'short_description' => 'Transform a corner of your home into a peaceful pooja space that invites divine energy and supports your daily spiritual practice.',
            'full_description' => '<h2>Why a Sacred Space Matters</h2><p>Having a dedicated sacred space in your home creates a physical anchor for your spiritual practice. It serves as a daily reminder to pause, reflect, and connect with the divine. Whether you have an entire room or just a small corner, the intention behind the space is what makes it sacred.</p><h2>Choosing the Right Location</h2><p>Traditionally, the northeast corner of your home (Ishaan corner) is considered the most auspicious direction for a prayer space, as per Vastu Shastra. Choose a clean, quiet area away from high-traffic zones. The space should feel peaceful and separate from everyday activities.</p><h2>Essential Elements</h2><ul><li><strong>Clean platform or shelf:</strong> Keep it elevated and always clean</li><li><strong>Deity idol or image:</strong> Choose deities you feel connected to</li><li><strong>Diya or oil lamp:</strong> Light represents divine presence and dispels darkness</li><li><strong>Incense holder:</strong> For purifying the space with sacred fragrance</li><li><strong>Bell:</strong> The sound of a bell purifies the atmosphere and signals the start of worship</li><li><strong>Fresh flowers:</strong> Offering flowers symbolises devotion and beauty</li><li><strong>Mala:</strong> Keep your Rudraksha or Karungali mala here when not wearing it</li></ul><h2>Daily Practice</h2><p>Visit your sacred space at least twice daily — morning and evening. Light the diya, offer a prayer, chant your mantra, and sit in silence for a few minutes. Consistency is more important than duration. Even 5 minutes of sincere devotion in your sacred space can profoundly shift your energy.</p>',
            'meta_title' => 'How to Create a Pooja Room - Sacred Home Space Guide',
            'meta_description' => 'Learn how to create a beautiful and sacred pooja space in your home with essential elements, Vastu tips, and daily practice guidance.',
            'status' => true,
        ]);

        Blog::create([
            'category_id' => $lifestyle->id,
            'title' => 'The Spiritual Significance of Wearing a Mala Every Day',
            'short_description' => 'Why wearing a sacred mala is more than just fashion — it is a daily reminder of your spiritual intention and divine connection.',
            'full_description' => '<h2>More Than Just Beads</h2><p>In today\'s world, malas have become popular as fashion accessories. But in the spiritual tradition, a mala is far more than decoration — it is a sacred tool for meditation, a carrier of spiritual energy, and a constant companion on your journey of self-discovery.</p><h2>The Power of 108 Beads</h2><p>Traditional malas contain 108 beads, a number deeply significant in Hindu, Buddhist, and yogic traditions. There are said to be 108 energy lines converging at the heart chakra, 108 Upanishads, and 108 sacred sites across India. Wearing 108 beads connects you with this vast web of spiritual significance.</p><h2>How a Mala Carries Energy</h2><p>When you use your mala for japa meditation — chanting a mantra while moving through each bead — the mala absorbs the vibrational energy of your practice. Over time, the beads become infused with your devotional energy, making the mala a personal spiritual object that resonates with your unique frequency.</p><h2>Choosing Your Mala</h2><p>Different materials serve different purposes:</p><ul><li><strong>Rudraksha:</strong> For meditation, clarity, and connection with Lord Shiva</li><li><strong>Karungali:</strong> For grounding, protection, and Saturn-related balance</li><li><strong>Tulsi:</strong> For devotion, especially to Lord Vishnu and Krishna</li><li><strong>Crystal/Sphatik:</strong> For purity, cooling energy, and Goddess worship</li></ul><h2>Wearing with Respect</h2><p>Treat your mala as a sacred object. Remove it before bathing or sleeping. Store it in a clean pouch when not in use. Do not let others touch your personal mala, as it carries your unique spiritual imprint. When you wear it daily, it becomes a silent prayer — a constant reminder of your connection to the divine.</p>',
            'meta_title' => 'Why Wear a Mala Daily - Spiritual Significance of Sacred Beads',
            'meta_description' => 'Discover the spiritual significance of wearing a mala daily — from the power of 108 beads to how different materials serve your spiritual journey.',
            'status' => true,
        ]);
    }
}
