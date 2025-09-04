@extends('layouts.app')

@section('title', 'À propos - AEMS')
@section('page-title', 'À propos')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="aems-card p-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold aems-text-green mb-4">À propos de l'AEMS</h1>
            <div class="w-24 h-1 bg-orange-400 mx-auto"></div>
        </div>

        <div class="prose prose-lg max-w-none">
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <p class="text-lg leading-relaxed text-gray-700 mb-6">
                    L'<strong>Association des Étudiants de Mitsoudjé au Sénégal (AEMS)</strong> 
                    rassemble les étudiants originaires de Mitsoudjé vivant au Sénégal. 
                    Notre mission est de contribuer à leur épanouissement académique, 
                    social et culturel, tout en valorisant leur identité et en renforçant 
                    les liens de solidarité entre les membres.
                </p>
            </div>

            <blockquote class="border-l-4 border-orange-400 pl-6 py-4 bg-orange-50 rounded-r-lg mb-8">
                <p class="text-lg italic text-gray-700">
                    "Ce site est un lieu d'archives pour conserver et partager nos moments 
                    marquants, nos réussites et nos célébrations. Il permet de transmettre 
                    la mémoire collective aux générations futures et de maintenir vivant 
                    l'esprit de notre communauté estudiantine."
                </p>
            </blockquote>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="aems-card p-6">
                    <h3 class="text-2xl font-bold aems-text-green mb-4">🎯 Notre Mission</h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-orange-400 mr-2">•</span>
                            Promouvoir l'excellence académique
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-400 mr-2">•</span>
                            Renforcer la solidarité entre membres
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-400 mr-2">•</span>
                            Valoriser la culture de Mitsoudjé
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-400 mr-2">•</span>
                            Contribuer au développement communautaire
                        </li>
                    </ul>
                </div>

                <div class="aems-card p-6">
                    <h3 class="text-2xl font-bold aems-text-green mb-4">🌟 Nos Valeurs</h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-orange-400 mr-2">•</span>
                            <strong>Unité :</strong> Travailler ensemble vers un objectif commun
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-400 mr-2">•</span>
                            <strong>Solidarité :</strong> S'entraider dans les moments difficiles
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-400 mr-2">•</span>
                            <strong>Développement :</strong> Progresser ensemble et individuellement
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-400 mr-2">•</span>
                            <strong>Excellence :</strong> Viser le meilleur dans tous nos projets
                        </li>
                    </ul>
                </div>
            </div>

            <div class="aems-card p-6">
                <h3 class="text-2xl font-bold aems-text-green mb-4">📚 Nos Activités</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-3xl mb-3">🎓</div>
                        <h4 class="font-semibold text-lg mb-2">Académiques</h4>
                        <p class="text-gray-600 text-sm">Soutien scolaire, conférences, ateliers de formation</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl mb-3">🎭</div>
                        <h4 class="font-semibold text-lg mb-2">Culturelles</h4>
                        <p class="text-gray-600 text-sm">Festivals, spectacles, célébrations traditionnelles</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl mb-3">🤝</div>
                        <h4 class="font-semibold text-lg mb-2">Sociales</h4>
                        <p class="text-gray-600 text-sm">Actions caritatives, projets communautaires</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8">
                <h3 class="text-2xl font-bold aems-text-green mb-4">Rejoignez-nous !</h3>
                <p class="text-gray-700 mb-6">
                    Si vous êtes étudiant originaire de Mitsoudjé au Sénégal, 
                    nous vous invitons à rejoindre notre communauté.
                </p>
                @auth
                    <a href="{{ route('dashboard') }}" class="aems-year-button">
                        Accéder au tableau de bord
                    </a>
                @else
                    <a href="{{ route('register') }}" class="aems-year-button">
                        S'inscrire maintenant
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
