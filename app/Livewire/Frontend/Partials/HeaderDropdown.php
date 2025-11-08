<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Component;

class HeaderDropdown extends Component
{
    public $gameCategorySlug = '';
    public $search = '';

    protected $loaded = [];

    protected $listeners = ['setGameCategorySlug'];

    public function setGameCategorySlug($gameCategorySlug)
    {
        if (!isset($this->loaded[$gameCategorySlug])) {
            $this->gameCategorySlug = $gameCategorySlug;
            $this->loaded[$gameCategorySlug] = true;
        } else {
            $this->gameCategorySlug = $gameCategorySlug;
        }
    }
    public function getContentProperty()
    {
        // return match($this->gameCategory) {
        //     'currency' => $this->getCurrencyGames(),
        //     'boosting' => $this->getBoostingServices(),
        //     'items' => $this->getGameItems(),
        //     'accounts' => $this->getAccounts(),
        //     'topups' => $this->getTopUps(),
        //     'coaching' => $this->getCoachingServices(),
        //     'gift-cards' => $this->getGiftCardServices(),
        //     default => [],
        // };

        foreach(gameCategories() as $gameCategory) {
            if($gameCategory['slug'] == $this->gameCategorySlug){
                return $gameCategory['games'];
                break;
            }
        };
        return [];
    }
    
    // private function getCurrencyGames()
    // {
    //     return [
    //         'popular' => [
    //             ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
    //             ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
    //             ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
    //             ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
    //             ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
    //             ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
    //             ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
    //             ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
    //             ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
    //             ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
    //             ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
    //             ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
    //         ],
    //         'all' => [
    //             'EA Sports FC Coins',
    //             'Albion Online Silver',
    //             'Animal Crossing: New Horizons Bells',
    //             'Black Desert Online Silver',
    //             'Blade & Soul NEO Divine Gems',
    //             'Blade Ball Tokens',
    //         ]
    //     ];
    // }
    
    // private function getBoostingServices()
    // {
    //      return [
    //         'popular' => [
    //             ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
    //             ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
    //             ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
    //             ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
    //             ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
    //             ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
    //             ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
    //             ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
    //             ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
    //             ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
    //             ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
    //             ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
    //         ],
    //         'all' => [
    //             'EA Sports FC Coins',
    //             'Albion Online Silver',
    //             'Animal Crossing: New Horizons Bells',
    //             'Black Desert Online Silver',
    //             'Blade & Soul NEO Divine Gems',
    //             'Blade Ball Tokens',
    //         ]
    //     ];
    // }
    
    // private function getGameItems()
    // {
    //     return [
    //         'popular' => [
    //             ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
    //             ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
    //             ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
    //             ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
    //             ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
    //             ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
    //             ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
    //             ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
    //             ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
    //             ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
    //             ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
    //             ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
    //         ],
    //         'all' => [
    //             'EA Sports FC Coins',
    //             'Albion Online Silver',
    //             'Animal Crossing: New Horizons Bells',
    //             'Black Desert Online Silver',
    //             'Blade & Soul NEO Divine Gems',
    //             'Blade Ball Tokens',
    //         ]
    //     ];
    // }
    
    // private function getAccounts()
    // {
    //     return [
    //         'popular' => [
    //             ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
    //             ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
    //             ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
    //             ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
    //             ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
    //             ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
    //             ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
    //             ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
    //             ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
    //             ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
    //             ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
    //             ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
    //         ],
    //         'all' => [
    //             'EA Sports FC Coins',
    //             'Albion Online Silver',
    //             'Animal Crossing: New Horizons Bells',
    //             'Black Desert Online Silver',
    //             'Blade & Soul NEO Divine Gems',
    //             'Blade Ball Tokens',
    //         ]
    //     ];
    // }
    
    // private function getTopUps()
    // {
    //       return [
    //         'popular' => [
    //             ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
    //             ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
    //             ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
    //             ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
    //             ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
    //             ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
    //             ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
    //             ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
    //             ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
    //             ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
    //             ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
    //             ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
    //         ],
    //         'all' => [
    //             'EA Sports FC Coins',
    //             'Albion Online Silver',
    //             'Animal Crossing: New Horizons Bells',
    //             'Black Desert Online Silver',
    //             'Blade & Soul NEO Divine Gems',
    //             'Blade Ball Tokens',
    //         ]
    //     ];
    // }
    
    // private function getCoachingServices()
    // {
    //      return [
    //         'popular' => [
    //             ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
    //             ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
    //             ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
    //             ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
    //             ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
    //             ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
    //             ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
    //             ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
    //             ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
    //             ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
    //             ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
    //             ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
    //         ],
    //         'all' => [
    //             'EA Sports FC Coins',
    //             'Albion Online Silver',
    //             'Animal Crossing: New Horizons Bells',
    //             'Black Desert Online Silver',
    //             'Blade & Soul NEO Divine Gems',
    //             'Blade Ball Tokens',
    //         ]
    //     ];
    // }

    // private function getGiftCardServices()
    // {
    //       return [
    //         'popular' => [
    //             ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
    //             ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
    //             ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
    //             ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
    //             ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
    //             ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
    //             ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
    //             ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
    //             ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
    //             ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
    //             ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
    //             ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
    //         ],
    //         'all' => [
    //             'EA Sports FC Coins',
    //             'Albion Online Silver',
    //             'Animal Crossing: New Horizons Bells',
    //             'Black Desert Online Silver',
    //             'Blade & Soul NEO Divine Gems',
    //             'Blade Ball Tokens',
    //         ]
    //     ];
    // }
    
    public function render()
    {
        return view('livewire.frontend.partials.header-dropdown');
    }
}
