<x-layouts.app>
    <x-slot name="title">Início | CONFIA</x-slot>

    <h2 class="text-center mt-3">Bem vindo, {{$loggedUser}}.</h2>


    <!-- <div style="display:flex;">
        <div style="width:50%;height:500px;background-color:red;"></div>
        <div style="width:50%;height:500px;background-color:blue;"></div>
    <div> -->


    <!-- query para ranquear os usuários que mais compartilharam notícias falsas (ICS) -->

    <!-- select * from
	(select detectenv.social_media_account.id_account_social_media, count(detectenv.news.classification_outcome) as total_fake_news
	from detectenv.post
	inner join detectenv.social_media_account
	 	on detectenv.post.id_social_media_account = detectenv.social_media_account.id_social_media_account
	inner join detectenv.news
	 	on detectenv.post.id_news = detectenv.news.id_news
	where detectenv.news.classification_outcome = true
	group by
		detectenv.social_media_account.id_account_social_media) tbl
    order by tbl.total_fake_news desc; -->
</x-layouts.app>
