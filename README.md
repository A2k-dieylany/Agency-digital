# 🚀 Sen Digital Solution — Agence Digitale Premium

> Site web professionnel pour une agence digitale sénégalaise, construit sur WordPress avec un design **Dark Mode** ultra-moderne.

![WordPress](https://img.shields.io/badge/WordPress-21759B?style=for-the-badge&logo=wordpress&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

---

## 🎯 Présentation

**Sen Digital Solution** est une plateforme web premium pour une agence digitale basée au Sénégal. Le site est conçu pour impressionner dès le premier regard avec un design sombre élégant, des animations fluides et une expérience utilisateur haut de gamme.

### ✨ Points forts
- 🌑 **Dark Mode Premium** — Design sombre avec glassmorphism et dégradés violet/rose
- 🎬 **Animations cinématiques** — Apparition au scroll, lévitation des images, gradient flow
- 📱 **100% Responsive** — Adapté mobile, tablette et desktop
- ⚡ **Ultra-rapide** — Cache agressif, GZIP, scripts différés, polices optimisées
- 🇫🇷 **Entièrement en français** — Interface, formulaire et contenu localisés
- 🔒 **Sécurisé** — Honeypots anti-spam, XML-RPC bloqué, headers de sécurité

---

## 📸 Sections de la page d'accueil

| # | Section | Description |
|---|---------|-------------|
| 1 | **Héro animé** | Titre avec effet blur-reveal + gradient flow infini |
| 2 | **Bandeau Marquee** | Technologies défilantes (WordPress, React, Figma...) |
| 3 | **Nos Services** | 3 colonnes avec images et hover effects |
| 4 | **Notre Agence** | Présentation avec image d'équipe |
| 5 | **Nos Réalisations** | Grille portfolio 2x2 avec overlay au survol |
| 6 | **Témoignages** | 3 cartes glassmorphism avec étoiles dorées |
| 7 | **Formulaire de Contact** | Contact Form 7 stylisé (champs sombres, bouton gradient) |
| 8 | **Mega Footer** | 4 colonnes : marque, services, liens, newsletter |

---

## 🛠️ Stack Technique

| Technologie | Rôle |
|-------------|------|
| **WordPress 6.x** | CMS & gestion de contenu |
| **Astra** (thème parent) | Base légère et performante |
| **Astra Child** | Thème enfant personnalisé (tout le code custom) |
| **Contact Form 7** | Formulaire de contact |
| **WP Fastest Cache** | Cache côté serveur |
| **Autoptimize** | Minification CSS/JS |
| **Space Grotesk** | Police des titres |
| **DM Sans** | Police du corps de texte |

---

## 📁 Structure du projet

```
wp-content/themes/astra-child/
├── style.css        # 🎨 Design complet (1300+ lignes)
│                    #    ├── Variables CSS & Design System
│                    #    ├── Header & Navigation
│                    #    ├── Hero Section
│                    #    ├── Services, Portfolio, Témoignages
│                    #    ├── Blog Archive
│                    #    ├── Animations & Keyframes
│                    #    ├── Scrollbar & Marquee
│                    #    ├── Contact Form (CF7)
│                    #    └── Mega Footer
│
├── functions.php    # ⚙️ Logique PHP
│                    #    ├── Enqueue styles & scripts
│                    #    ├── Google Fonts (preconnect)
│                    #    ├── Optimisations performances
│                    #    ├── Sécurité (honeypots, spam)
│                    #    ├── Mega Footer custom
│                    #    └── Shortcode [sds_marquee]
│
└── script.js        # 🎭 Animations JavaScript
                     #    ├── Scroll Reveal (IntersectionObserver)
                     #    └── Staggered columns effect
```

---

## 🚀 Installation

### Prérequis
- **XAMPP** / **WAMP** / **MAMP** (ou tout serveur Apache + PHP + MySQL)
- **WordPress 6.x** installé
- **Thème Astra** installé et activé

### Étapes

1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/A2k-dieylany/Agency-digital.git
   ```

2. **Copier le thème enfant** dans votre installation WordPress
   ```bash
   cp -r wp-content/themes/astra-child/ /chemin/vers/wordpress/wp-content/themes/
   ```

3. **Activer le thème enfant** dans WordPress
   > Apparence → Thèmes → Astra Child → Activer

4. **Installer les plugins requis**
   - Contact Form 7
   - WP Fastest Cache
   - Autoptimize

5. **Configurer le contenu**
   - Créer les pages : Accueil, Services, À propos, Portfolio, Blog, Contact
   - Définir "Accueil" comme page d'accueil statique
   - Créer le menu de navigation "Menu Principal"

---

## 🎨 Design System

### Palette de couleurs

| Variable | Valeur | Usage |
|----------|--------|-------|
| `--color-bg-dark` | `#09090b` | Arrière-plan principal |
| `--color-surface` | `#141419` | Cartes et conteneurs |
| `--color-primary` | `#8b5cf6` | Violet — Accent principal |
| `--color-accent` | `#ec4899` | Rose — CTA et boutons |
| `--color-white` | `#f8fafc` | Texte principal |
| `--color-gray` | `#94a3b8` | Texte secondaire |

### Typographie

| Police | Usage | Poids |
|--------|-------|-------|
| **Space Grotesk** | Titres (h1-h6) | 700 |
| **DM Sans** | Corps de texte | 400, 500 |

---

## 📝 Blog

3 articles SEO professionnels pré-intégrés :
1. **5 tendances web design qui domineront en 2026**
2. **Pourquoi votre entreprise a besoin d'un site web en 2026**
3. **SEO : Les 7 erreurs fatales qui tuent votre visibilité Google**

---

## 🔧 Configuration recommandée pour la production

- [ ] Activer `FORCE_SSL_ADMIN` dans `wp-config.php`
- [ ] Configurer **WP Mail SMTP** pour la réception des emails
- [ ] Mettre à jour les URLs avec `wp-cli search-replace`
- [ ] Configurer les titres et méta-descriptions avec **Yoast SEO**
- [ ] Remplacer les photos de témoignages par de vrais clients
- [ ] Ajouter les vrais liens vers les réseaux sociaux dans le footer

---

## 👨‍💻 Auteur

**Sen Digital Solution**  
📧 sendigitalsolution@gmail.com  
🌍 Dakar, Sénégal

---

## 📄 Licence

Ce projet est sous licence privée. Tous droits réservés © 2026 Sen Digital Solution.
