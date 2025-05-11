
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards of Chaos</title>
    <style>
        /* ==== CSS with "Cards of Chaos" Color Scheme ==== */
        :root {
            /* Define colors based on Cards of Chaos website */
            --theme-bg-primary: #181818; /* Very dark main background */
            --theme-bg-secondary: #1f1f1f; /* Slightly lighter dark for sections */
            --theme-text-primary: #e0e0e0; /* Light grey/white primary text */
            --theme-text-secondary: #a0a0b0; /* Medium grey secondary text */
            --theme-accent-primary: #29f3c4; /* Teal/Cyan accent (like Play Now) */
            --theme-accent-secondary: #f7b731; /* Orange/Yellow accent (like Login) */
            --theme-border-light: #555; /* Subtle border */
            --theme-border-highlight: var(--theme-accent-primary); /* Use primary accent for highlights */

            /* Standard UNO Colors (Keep for gameplay cards) */
            --uno-red: #E53935;
            --uno-yellow: #FDD835;
            --uno-green: #43A047;
            --uno-blue: #1E88E5;
            --uno-black: #333; /* Text on yellow cards */
            --uno-white: #fff; /* Text on other cards */

            /* Layout Variables */
            --card-width: 70px;
            --card-height: 105px;
            --border-radius: 6px; /* Slightly less rounded */
            --gap-size: 1rem;
        }

        /* --- General Styling --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--theme-bg-primary); /* Apply main dark bg */
            color: var(--theme-text-primary); /* Default light text */
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: var(--gap-size);
            box-sizing: border-box;
            margin: 0; /* Remove default body margin */
        }

        #game-board {
            display: grid;
            grid-template-rows: auto auto 1fr auto auto; /* Opponent Info, Opponent Hand, Center Area, Player Hand Area, Status Area */
            grid-template-areas:
                "opponent-info"
                "opponent-hand"
                "center-area"
                "player-hand-area"
                "status-area";
            gap: var(--gap-size);
            background-color: var(--theme-bg-secondary); /* Use secondary dark for board surface */
            padding: var(--gap-size);
            border-radius: var(--border-radius);
            width: 100%;
            max-width: 1500px;
            border: 2px solid var(--theme-border-light); /* Subtle border */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5); /* Stronger shadow on dark bg */
        }

        /* --- Section Styling --- */
        .player-area {
            background-color: rgba(0,0,0,0.1); /* Subtle darker area on board */
            padding: var(--gap-size);
            border-radius: var(--border-radius);
        }
        #opponent-info-area { grid-area: opponent-info; text-align: center;} /* Centering heading */
        #opponent-hand-area { grid-area: opponent-hand; min-height: calc(var(--card-height) + 15px); }
        #player-hand-area { grid-area: player-hand-area; text-align: center;} /* Centering heading */


        .player-area h2 {
            margin: 0 0 var(--gap-size) 0;
            color: var(--theme-text-primary);
            text-align: center;
            font-size: 1.1em;
            font-weight: 600;
            border-bottom: 1px solid var(--theme-border-light);
            padding-bottom: 0.5rem;
        }
        #opponent-card-count {
            color: var(--theme-text-secondary); /* Use secondary grey text */
        }


        /* --- Center Area (Deck/Discard) --- */
        #center-area {
            grid-area: center-area;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: calc(var(--gap-size) * 2);
            padding: var(--gap-size) 0;
            min-height: calc(var(--card-height) + 20px);
        }

        #deck-area, #discard-area {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #chosen-color-indicator {
            font-weight: 600; /* Bold */
            margin-top: 8px; /* More space */
            color: var(--theme-text-primary);
            text-shadow: 1px 1px 1px rgba(0,0,0,0.7);
            min-height: 1.3em;
            text-align: center;
            width: calc(var(--card-width) + 20px);
            background-color: rgba(0,0,0,0.5); /* Darker indicator background */
            border-radius: 4px;
            padding: 4px 0;
            font-size: 0.9em;
            border: 1px solid var(--theme-border-light);
        }

        /* --- Hand Styling --- */
        .hand {
            display: flex;
            overflow-x: auto;
            overflow-y: hidden;
            flex-wrap: nowrap;
            padding: 5px 5px 15px 5px;
            min-height: calc(var(--card-height) + 10px);
            scrollbar-width: thin;
            scrollbar-color: var(--theme-text-secondary) var(--theme-bg-secondary); /* Scrollbar colors */
            justify-content: flex-start; /* Align cards to the left within scroll */
        }
        .hand::-webkit-scrollbar { height: 8px; }
        .hand::-webkit-scrollbar-track { background: var(--theme-bg-secondary); border-radius: 4px;}
        .hand::-webkit-scrollbar-thumb { background-color: var(--theme-text-secondary); border-radius: 4px; border: 2px solid var(--theme-bg-secondary); }
        .hand::-webkit-scrollbar-thumb:hover { background-color: var(--theme-text-primary); }


        /* --- Card Styling (General) --- */
        .card {
            border: 1px solid var(--uno-black); /* Keep black border for contrast */
            border-radius: var(--border-radius);
            width: var(--card-width);
            height: var(--card-height);
            margin-right: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 1.4em;
            position: relative;
            background-color: var(--uno-white); /* Base color for text contrast calculation */
            box-shadow: 2px 2px 5px rgba(0,0,0,0.4); /* Slightly stronger shadow */
            padding: 5px;
            box-sizing: border-box;
            user-select: none;
            flex-shrink: 0;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border 0.2s ease;
            overflow: hidden;
        }
        .hand .card:last-child { margin-right: 0; }

        .card-small-text {
            font-size: 0.7em;
            font-weight: 600;
            position: absolute;
            line-height: 1;
        }
        .card-top-left { top: 6px; left: 6px; }
        .card-bottom-right { bottom: 6px; right: 6px; transform: rotate(180deg); }

        /* --- UNO Card Specific Colors (Kept Standard) --- */
        .card-red { background-image: url("emperor.jpg"); background-size:cover;background-color: var(--uno-red); color: var(--uno-red); }
        .card-yellow { background-image: url("hierophant.jpg"); background-size:cover; background-color: var(--uno-yellow); color: var(--uno-yellow); } /* Yellow needs dark text */
        .card-green { background-image: url("high_priestess.jpg"); background-size:cover; background-color: var(--uno-green); color: var(--uno-green); }
        .card-blue { background-image: url("empress.jpg"); background-size:cover; background-color: var(--uno-blue); color: var(--uno-blue); }
        .card-wild {
            /* Keep multi-color wild background */
            background-image : url("wild.jpg"); background-size:cover;
            color: var(--uno-black);
        }

        
        .card-back {
            background-image: url('cardback.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            color: var(--theme-text-primary);
            font-size: 1.5em;
            background-image: none;
            border: 2px solid var(--theme-accent-secondary); 
            display:flex;
            align-items: center;
            justify-content:center;
        }
        .card-back::before {
            content: "DRAW CARD";
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            font-style: italic;
            font-weight: bold;
            font-size: 1.8em;
            color: var(--theme-accent-primary); 
            text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
            transform: skewX(-10deg);
        }

        #opponent-hand .card {
            background-image: url('cardback.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            color: transparent;
            border: 2px solid var(--theme-accent-secondary);
        }
        #opponent-hand .card > span { visibility: hidden; }
        #opponent-hand .card::before {
            
            content: "";
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            font-style: italic;
            font-weight: bold;
            font-size: 1.8em;
            color: var(--theme-accent-primary);
            text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
            transform: skewX(-10deg) translate(-50%, -50%);
            visibility: visible;
            position: absolute;
            top: 50%; left: 50%;
        }

        /* --- Player Hand Interactions --- */
        #player-hand .card.playable {
            border: 3px solid var(--theme-border-highlight); /* Use Teal/Cyan border */
            cursor: pointer;
            transform: translateY(-8px);
        }
        #player-hand .card.playable:hover {
            transform: translateY(-12px) scale(1.03);
            box-shadow: 0 4px 12px var(--theme-border-highlight); /* Glow with highlight color */
        }

        /* --- Deck Styling --- */
        #deck {
            cursor: pointer;
            /* Uses .card-back styling from above */
        }
        #deck:hover {
            box-shadow: 0 0 12px var(--theme-accent-secondary); /* Glow with secondary accent */
            transform: scale(1.03);
        }
        #discard-pile .card {
            /* No special styling needed unless desired */
        }
        #discard-pile .card:hover { /* Disable hover effects on discard */
             transform: none;
             box-shadow: 2px 2px 5px rgba(0,0,0,0.4);
             cursor: default;
        }


        /* --- Status Area --- */
        #status-area {
            grid-area: status-area;
            text-align: center;
            padding: 0.75rem;
            background-color: rgba(0, 0, 0, 0.4); /* Darker overlay */
            color: var(--theme-text-primary);
            border-radius: var(--border-radius);
            margin-top: 0;
            border: 1px solid var(--theme-border-light);
        }

        #status-message {
            font-weight: 600;
            font-size: 1.1em;
            min-height: 1.3em;
        }

        /* --- Overlay for Wild Color Choice --- */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85); /* Darker overlay */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0s linear 0.3s;
        }
        .overlay:not(.hidden) { opacity: 1; visibility: visible; transition: opacity 0.3s ease; }

        /* Container for overlay content */
        #wild-color-choice > div { /* Direct child div for styling */
            background-color: var(--theme-bg-secondary); /* Match section background */
            padding: 2rem;
            border-radius: var(--border-radius);
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
            border: 1px solid var(--theme-border-light);
        }

        .overlay h3 {
            color: var(--theme-text-primary);
            margin-top: 0;
            margin-bottom: 1.5rem;
            font-size: 1.4em;
        }

        /* Wild Color Choice Buttons - Use UNO colors but theme style */
        .color-choice-btn {
            padding: 10px 20px;
            margin: 8px;
            font-size: 1.1em;
            font-weight: bold;
            border: 2px solid transparent; /* Border placeholder */
            border-radius: var(--border-radius);
            cursor: pointer;
            min-width: 100px;
            transition: transform 0.1s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .color-choice-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            border-color: var(--uno-white); /* White border on hover */
        }
        /* Keep UNO colors for button backgrounds */
        .color-choice-btn[data-color="Red"] { background-color: var(--uno-red); color: var(--uno-white); }
        .color-choice-btn[data-color="Yellow"] { background-color: var(--uno-yellow); color: var(--uno-black); }
        .color-choice-btn[data-color="Green"] { background-color: var(--uno-green); color: var(--uno-white); }
        .color-choice-btn[data-color="Blue"] { background-color: var(--uno-blue); color: var(--uno-white); }


        /* --- Basic Responsiveness --- */
        @media (max-width: 768px) {
            :root {
                --card-width: 65px;
                --card-height: 98px;
                --gap-size: 0.75rem;
            }
            /* Adjustments if needed */
        }

        @media (max-width: 480px) {
             :root {
                --card-width: 55px;
                --card-height: 83px;
                --gap-size: 0.5rem;
            }
            body { padding: 0.5rem; }
            #game-board { padding: 0.5rem; border-width: 1px;}
            .player-area { padding: 0.5rem; }
            .player-area h2 { font-size: 0.9em; margin-bottom: 0.5rem;}
            .card { font-size: 1.1em; margin-right: 5px; }
            .card-small-text { font-size: 0.6em; top: 4px; left: 4px; }
            .card-bottom-right { bottom: 4px; right: 4px; }
            .card-back::before { font-size: 1.4em; }
            #opponent-hand .card::before { font-size: 1.4em; }
            .color-choice-btn { padding: 8px 15px; font-size: 1em; margin: 4px;}
            #wild-color-choice > div { padding: 1.5rem; }
            .hand { padding-bottom: 8px; }
            .hand::-webkit-scrollbar { height: 6px; }
        }

       
        #play-again-btn { 
            margin-top: 1rem;
            padding: 0.8rem 1.6rem;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            border-radius: var(--border-radius);
            border: none;
            background-color: var(--theme-accent-primary);
            color: var(--theme-bg-primary);
            transition: background-color 0.3s ease;
        }
        #play-again-btn:hover {
            background-color: darken(var(--theme-accent-primary), 10%); 
        }

    </style>
</head>
<body>
    <div id="game-board">
        <div id="opponent-info-area" class="player-area">
            <h2>Opponent (<span id="opponent-card-count">0</span> cards)</h2>
        </div>
        <div id="opponent-hand-area" class="player-area">
            <div id="opponent-hand" class="hand">
                </div>
        </div>

        <div id="center-area">
            <div id="deck-area">
                <div id="deck" class="card card-back"></div>
            </div>
            <div id="discard-area">
                <div id="discard-pile" class="card">
                    </div>
                <p id="chosen-color-indicator"></p>
            </div>
        </div>

        <div id="player-hand-area" class="player-area">
             <h2>Your Hand</h2>
            <div id="player-hand" class="hand">
                </div>
        </div>

        <div id="status-area">
            <p id="status-message">Game loading...</p>
            </div>
    </div>

    <div id="wild-color-choice" class="overlay hidden">
        <div> <h3>Choose a color:</h3>
            <button class="color-choice-btn" data-color="Red">Red</button>
            <button class="color-choice-btn" data-color="Yellow">Yellow</button>
            <button class="color-choice-btn" data-color="Green">Green</button>
            <button class="color-choice-btn" data-color="Blue">Blue</button>
        </div>
    </div>


    <script>
        
        document.addEventListener('DOMContentLoaded', () => {
            
            const playerHandElement = document.getElementById('player-hand');
            const opponentHandElement = document.getElementById('opponent-hand');
            const deckElement = document.getElementById('deck');
            const discardPileElement = document.getElementById('discard-pile');
            const statusMessageElement = document.getElementById('status-message');
            const opponentCardCountElement = document.getElementById('opponent-card-count');
            const wildColorChoiceOverlay = document.getElementById('wild-color-choice');
            const colorChoiceButtons = document.querySelectorAll('.color-choice-btn');
            const chosenColorIndicator = document.getElementById('chosen-color-indicator');
            const statusAreaElement = document.getElementById('status-area'); 


            // --- Game State Variables ---
            let deck = [];
            let playerHand = [];
            let opponentHand = [];
            let discardPile = [];
            let currentPlayer = 'player'; // 'player' or 'opponent'
            let chosenWildColor = null; // Track chosen color after a Wild
            let drawPenalty = 0; // For Draw Two / Wild Draw Four
            let gameIsOver = false; // Flag to control interactions after game end

            // --- Game Logic Functions ---

            function createDeck() {
                const colors = ['Red', 'Yellow', 'Green', 'Blue'];
                const values = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'Skip', 'Reverse', 'Draw Two'];
                const wildValues = ['Wild', 'Wild Draw Four'];
                let newDeck = [];

                for (const color of colors) {
                    for (const value of values) {
                        newDeck.push({ color, value });
                        if (value !== '0') { // Two of each number 1-9 and action cards
                            newDeck.push({ color, value });
                        }
                    }
                }

                for (let i = 0; i < 4; i++) {
                    newDeck.push({ color: 'Wild', value: 'Wild' });
                    newDeck.push({ color: 'Wild', value: 'Wild Draw Four' });
                }
                return newDeck;
            }

            function shuffleDeck(deckToShuffle) {
                for (let i = deckToShuffle.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [deckToShuffle[i], deckToShuffle[j]] = [deckToShuffle[j], deckToShuffle[i]]; // Swap
                }
            }

            function dealCards(deckToDealFrom, numCards = 7) {
                playerHand = []; // Clear hands before dealing
                opponentHand = [];
                for (let i = 0; i < numCards; i++) {
                    if (deckToDealFrom.length > 0) playerHand.push(deckToDealFrom.pop());
                    if (deckToDealFrom.length > 0) opponentHand.push(deckToDealFrom.pop());
                }
            }

            function renderCard(card) {
                const cardDiv = document.createElement('div');
                cardDiv.classList.add('card');
                if (card.color !== 'Wild') {
                     cardDiv.classList.add(`card-${card.color.toLowerCase()}`);
                } else {
                     // Add wild class for potential specific wild styling (like border only)
                     cardDiv.classList.add('card-wild');
                }

                const valueText = card.value.replace(' ', '');
                const mainValue = document.createElement('span');
                mainValue.textContent = valueText;

                const topLeft = document.createElement('span');
                topLeft.textContent = valueText;
                topLeft.classList.add('card-small-text', 'card-top-left');

                const bottomRight = document.createElement('span');
                bottomRight.textContent = valueText;
                bottomRight.classList.add('card-small-text', 'card-bottom-right');

                cardDiv.appendChild(mainValue);
                cardDiv.appendChild(topLeft);
                cardDiv.appendChild(bottomRight);

                cardDiv.dataset.color = card.color;
                cardDiv.dataset.value = card.value;

                return cardDiv;
            }

            function renderHand(hand, element, isPlayer) {
                element.innerHTML = ''; // Clear current hand display
                hand.forEach((card, index) => {
                    const cardElement = renderCard(card);
                    if (isPlayer) {
                        cardElement.dataset.index = index;
                        // Add click listener only if it's player's turn, card is playable, and game not over
                        if (!gameIsOver && currentPlayer === 'player' && drawPenalty === 0 && isPlayable(card, discardPile[discardPile.length - 1], chosenWildColor)) {
                            cardElement.classList.add('playable');
                            cardElement.addEventListener('click', handlePlayerPlayCard);
                        }
                    } else {
                         cardElement.classList.add('card-back');
                         cardElement.innerHTML = ''; // Clear value text for opponent
                    }
                    element.appendChild(cardElement);
                });
                if (!isPlayer) {
                    opponentCardCountElement.textContent = hand.length;
                }
                // Scroll hand to the beginning
                 element.scrollLeft = 0;
            }

             function renderDiscardPile() {
                if (discardPile.length > 0) {
                    const topCard = discardPile[discardPile.length - 1];
                    const cardElement = renderCard(topCard);
                    // If the top card is Wild and a color was chosen, reflect it visually
                    if (topCard.color === 'Wild' && chosenWildColor) {
                         cardElement.style.borderColor = chosenWildColor; // Use chosen color for border emphasis
                         cardElement.style.borderWidth = '3px';
                         chosenColorIndicator.textContent = `Color: ${chosenWildColor}`;
                         chosenColorIndicator.style.color = chosenWildColor; // Use color for text too
                         chosenColorIndicator.style.opacity = '1';
                    } else {
                         chosenColorIndicator.textContent = ''; // Clear indicator
                         chosenColorIndicator.style.opacity = '0'; // Hide indicator
                    }
                    discardPileElement.innerHTML = ''; // Clear previous top card
                    discardPileElement.appendChild(cardElement);
                } else {
                    discardPileElement.innerHTML = ''; // Clear if empty
                     chosenColorIndicator.textContent = '';
                     chosenColorIndicator.style.opacity = '0';
                }
            }


            function updateStatus(message) {
                statusMessageElement.textContent = message;
            }

            function isPlayable(card, topCard, wildColor) {
                 if (!topCard) return false; // Cannot play if discard pile somehow empty after start

                if (card.color === 'Wild') {
                    // Add check for Wild Draw Four condition if desired (must not have other playable cards)
                    return true;
                }
                if (topCard.color === 'Wild' && wildColor) {
                    return card.color === wildColor;
                }
                return card.color === topCard.color || card.value === topCard.value;
            }

            function handlePlayerPlayCard(event) {
                if (gameIsOver || currentPlayer !== 'player' || drawPenalty > 0) return;

                const cardIndex = parseInt(event.currentTarget.dataset.index);
                if (isNaN(cardIndex) || cardIndex < 0 || cardIndex >= playerHand.length) return; // Safety check

                const playedCard = playerHand[cardIndex];
                const topCard = discardPile[discardPile.length - 1];

                if (isPlayable(playedCard, topCard, chosenWildColor)) {
                    playerHand.splice(cardIndex, 1);
                    discardPile.push(playedCard);
                     chosenWildColor = null;

                    renderHand(playerHand, playerHandElement, true);
                    renderDiscardPile();

                    if (playerHand.length === 0) {
                        updateStatus("YOU WIN!");
                        endGame();
                        return;
                    }

                    if (playedCard.color === 'Wild') {
                        showWildColorChoice(playedCard);
                    } else {
                         applyCardEffects(playedCard);
                         switchTurn();
                    }
                } else {
                    updateStatus("You can't play that card!");
                }
            }

             function showWildColorChoice(playedCard) {
                 if (gameIsOver) return;
                wildColorChoiceOverlay.classList.remove('hidden');
                wildColorChoiceOverlay.dataset.playedCardValue = playedCard.value;
            }

            function handleColorChoice(event) {
                if (gameIsOver) return;
                chosenWildColor = event.target.dataset.color;
                wildColorChoiceOverlay.classList.add('hidden');
                renderDiscardPile(); 

                const playedValue = wildColorChoiceOverlay.dataset.playedCardValue;
                const wildCardEffect = { color: 'Wild', value: playedValue };
                 applyCardEffects(wildCardEffect);
                 switchTurn();
            }


            function handlePlayerDrawCard() {
                if (gameIsOver || currentPlayer !== 'player') return;

                if (drawPenalty > 0) {
                     updateStatus(`You must draw ${drawPenalty} cards!`);
                    for (let i = 0; i < drawPenalty; i++) {
                         if (deck.length === 0) if (!replenishDeck()) break;
                         if(deck.length > 0) playerHand.push(deck.pop());
                    }
                    const penaltyDrawn = drawPenalty; 
                    drawPenalty = 0;
                    renderHand(playerHand, playerHandElement, true);
                    updateStatus(`Drew ${penaltyDrawn} penalty card(s).`); 
                     setTimeout(switchTurn, 1000); 
                    return;
                }

                if (deck.length === 0) {
                    if (!replenishDeck()){
                        updateStatus("Deck is empty and cannot reshuffle! Turn passes.");
                        switchTurn();
                        return;
                    }
                }
                if (deck.length > 0) {
                    const drawnCard = deck.pop();
                    playerHand.push(drawnCard);
                    updateStatus(`You drew: ${drawnCard.color} ${drawnCard.value}`);
                    renderHand(playerHand, playerHandElement, true);

                    const topCard = discardPile[discardPile.length - 1];
                    if (isPlayable(drawnCard, topCard, chosenWildColor)) {
                        updateStatus(`You drew a playable card: ${drawnCard.color} ${drawnCard.value}. Click it to play.`);
                        
                    } else {
                        updateStatus(`You drew: ${drawnCard.color} ${drawnCard.value}. Cannot play.`);
                        setTimeout(switchTurn, 1000); 
                    }
                }
            }

            function replenishDeck() {
                 if (discardPile.length <= 1) {
                     console.warn("Not enough cards in discard to replenish deck.");
                     return false;
                 }
                 const topCard = discardPile.pop();
                 deck = [...discardPile];
                 shuffleDeck(deck);
                 discardPile = [topCard];
                 console.log("Deck replenished from discard pile.");
                 renderDiscardPile();
                 
                 deckElement.classList.remove('empty'); 
                 return true;
            }


             function applyCardEffects(card) {
                 if(card.color !== 'Wild') {
                    
                 }

                 switch (card.value) {
                     case 'Skip': 
                     case 'Reverse': 
                         break;
                     case 'Draw Two':
                         drawPenalty = 2;
                         break;
                    case 'Wild Draw Four':
                         drawPenalty = 4;
                         break;
                     case 'Wild':
                         
                         break;
                 }
             }


            function switchTurn() {
                 if (gameIsOver) return;

                 const previousPlayer = currentPlayer;
                 const cardPlayed = discardPile[discardPile.length - 1];
                 let nextPlayer = (currentPlayer === 'player') ? 'opponent' : 'player';
                 let turnSkipped = false;

                 if (cardPlayed && (cardPlayed.value === 'Skip' || cardPlayed.value === 'Reverse')) {
                     nextPlayer = currentPlayer;
                     turnSkipped = true;
                     updateStatus(`${previousPlayer === 'player' ? 'Opponent' : 'Your'} turn was skipped! ${previousPlayer === 'player' ? 'Your' : 'Opponent\'s'} turn again.`);
                     drawPenalty = 0; 
                 }

                 currentPlayer = nextPlayer;

                 
                 if (!turnSkipped) {
                     if (drawPenalty === 0) {
                         updateStatus(`${currentPlayer === 'player' ? 'Your' : "Opponent's"} turn.`);
                     } else {
                         updateStatus(`${currentPlayer === 'player' ? 'Your' : "Opponent's"} turn. Must draw ${drawPenalty}.`);
                     }
                 }

                
                 if (previousPlayer !== currentPlayer && cardPlayed?.color !== 'Wild' && !chosenWildColor) {
                      chosenWildColor = null;
                      renderDiscardPile(); 
                 }

               
                 deckElement.removeEventListener('click', handlePlayerDrawCard);
                 playerHandElement.querySelectorAll('.card').forEach(card => card.removeEventListener('click', handlePlayerPlayCard));


                 if (currentPlayer === 'opponent') {
                    renderHand(playerHand, playerHandElement, true); 
                    setTimeout(handleOpponentTurn, 1500); 
                 } else { 
                     if (drawPenalty > 0) {
                         deckElement.addEventListener('click', handlePlayerDrawCard); 
                         renderHand(playerHand, playerHandElement, true); 
                     } else {
                         deckElement.addEventListener('click', handlePlayerDrawCard);
                         renderHand(playerHand, playerHandElement, true); 
                     }
                 }
            }


            function handleOpponentTurn() {
                 if (gameIsOver) return;

                if (drawPenalty > 0) {
                    updateStatus(`Opponent must draw ${drawPenalty} cards!`);
                    for (let i = 0; i < drawPenalty; i++) {
                         if (deck.length === 0) if (!replenishDeck()) break;
                         if(deck.length > 0) opponentHand.push(deck.pop());
                    }
                    const penaltyDrawn = drawPenalty; 
                    drawPenalty = 0;
                    renderHand(opponentHand, opponentHandElement, false);
                    updateStatus(`Opponent drew ${penaltyDrawn} penalty card(s).`);
                     setTimeout(switchTurn, 1000);
                    return;
                }


               
                const topCard = discardPile[discardPile.length - 1];
                let cardToPlayIndex = -1;
                let bestCardRank = -1; 

                for (let i = 0; i < opponentHand.length; i++) {
                    const currentCard = opponentHand[i];
                    if (isPlayable(currentCard, topCard, chosenWildColor)) {
                        let currentRank = 0;
                        if (['Skip', 'Reverse', 'Draw Two'].includes(currentCard.value)) {
                            currentRank = 3;
                        } else if (currentCard.color !== 'Wild') {
                            currentRank = 2;
                        } else if (currentCard.value === 'Wild') {
                            currentRank = 1;
                        } else { 
                       
                            currentRank = 0;
                        }

                        if (currentRank > bestCardRank) {
                            bestCardRank = currentRank;
                            cardToPlayIndex = i;
                        }
                        
                        if (bestCardRank === 3) break;
                    }
                }


                if (cardToPlayIndex !== -1) {
                    const playedCard = opponentHand.splice(cardToPlayIndex, 1)[0];
                    discardPile.push(playedCard);
                     chosenWildColor = null;

                    updateStatus(`Opponent played: ${playedCard.color !== 'Wild' ? playedCard.color : ''} ${playedCard.value}`);
                    renderHand(opponentHand, opponentHandElement, false);
                    renderDiscardPile();

                    if (opponentHand.length === 0) {
                        updateStatus("Opponent Wins!");
                        endGame();
                        return;
                    }

                    if (playedCard.color === 'Wild') {
                        chosenWildColor = chooseAIWildColor();
                         updateStatus(`Opponent played ${playedCard.value} and chose ${chosenWildColor}!`);
                         renderDiscardPile();
                         applyCardEffects(playedCard);
                         switchTurn();
                    } else {
                        applyCardEffects(playedCard);
                        switchTurn();
                    }

                } else {
                    updateStatus("Opponent draws a card.");
                     if (deck.length === 0) {
                        if (!replenishDeck()){
                             updateStatus("Opponent tried to draw, but deck is empty and cannot reshuffle!");
                             switchTurn();
                             return;
                         }
                     }
                    if (deck.length > 0) {
                        opponentHand.push(deck.pop());
                        renderHand(opponentHand, opponentHandElement, false);
                    }
                     switchTurn();
                }
            }

            function chooseAIWildColor() {
                 const colorCounts = { Red: 0, Yellow: 0, Green: 0, Blue: 0 };
                 let maxCount = 0;
                 const colors = ['Red', 'Yellow', 'Green', 'Blue'];

                 opponentHand.forEach(card => {
                     if (card.color !== 'Wild') colorCounts[card.color]++;
                 });

                 let potentialColors = [];
                 for (const color of colors) {
                     if (colorCounts[color] > maxCount) {
                         maxCount = colorCounts[color];
                         potentialColors = [color];
                     } else if (colorCounts[color] === maxCount && maxCount > 0) {
                          potentialColors.push(color);
                     }
                 }

                 return potentialColors.length > 0
                    ? potentialColors[Math.floor(Math.random() * potentialColors.length)]
                    : colors[Math.floor(Math.random() * colors.length)];
            }


            function startGame() {
                gameIsOver = false; 
                deck = createDeck();
                shuffleDeck(deck);

                discardPile = [];
                 chosenWildColor = null;
                 drawPenalty = 0;

                
                const existingButton = document.getElementById('play-again-btn');
                 if(existingButton) existingButton.remove();

               
                 deckElement.removeEventListener('click', handlePlayerDrawCard);
                 colorChoiceButtons.forEach(button => button.removeEventListener('click', handleColorChoice)); 

                dealCards(deck);

                let startCard = deck.pop();
                while (startCard.value === 'Wild Draw Four') {
                    if (deck.length < 5) deck.push(...createDeck()); 
                    deck.splice(Math.floor(Math.random() * deck.length), 0, startCard);
                    startCard = deck.pop();
                }
                discardPile.push(startCard);


               
                renderHand(playerHand, playerHandElement, true); 
                renderHand(opponentHand, opponentHandElement, false);
                renderDiscardPile();

               
                 let startingPlayer = 'player';
                 applyCardEffects(startCard);

                 if (startCard.color === 'Wild') {
                     chosenWildColor = chooseAIWildColor(); 
                     updateStatus(`Starting card is Wild! Opponent chose ${chosenWildColor}. Your turn.`);
                     renderDiscardPile();
                     startingPlayer = 'player';
                 } else if (startCard.value === 'Skip' || startCard.value === 'Reverse') {
                     startingPlayer = 'opponent';
                     updateStatus(`Starting card is ${startCard.value}. Opponent starts.`);
                 } else if (startCard.value === 'Draw Two') {
                     startingPlayer = 'player';
                     updateStatus(`Starting card is Draw Two. Your turn: Must draw ${drawPenalty}!`);
                 } else {
                     startingPlayer = 'player';
                     updateStatus("Your turn.");
                 }

                 currentPlayer = startingPlayer;

                
                 colorChoiceButtons.forEach(button => button.addEventListener('click', handleColorChoice));

                 
                 if (currentPlayer === 'player') {
                     if (drawPenalty > 0) {
                         deckElement.addEventListener('click', handlePlayerDrawCard); 
                     } else {
                         deckElement.addEventListener('click', handlePlayerDrawCard);
                         renderHand(playerHand, playerHandElement, true); 
                     }
                 } else { // AI Starts
                     renderHand(playerHand, playerHandElement, true); 
                     setTimeout(handleOpponentTurn, 1500);
                 }
            }

            function endGame() {
                gameIsOver = true; 
                
                deckElement.removeEventListener('click', handlePlayerDrawCard);
                playerHandElement.querySelectorAll('.card').forEach(card => {
                    card.removeEventListener('click', handlePlayerPlayCard);
                    card.classList.remove('playable');
                    card.style.cursor = 'default';
                });
                wildColorChoiceOverlay.classList.add('hidden');

                
                if (!document.getElementById('play-again-btn')) {
                    const playAgainButton = document.createElement('button');
                     playAgainButton.textContent = 'Play Again?';
                     playAgainButton.id = 'play-again-btn'; 
                     playAgainButton.onclick = startGame; 
                     statusAreaElement.appendChild(playAgainButton); 
                }
            }

            startGame();

        });
    </script>

</body>
</html>