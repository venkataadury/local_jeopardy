# local_jeopardy
Your own local jeopardy server. Easy to Edit, easier to run!

## Starting the PHP server
To start, clone the git repository to a folder. 
If you are using linux, navigate to the repository folder. Then run:
`php -S localhost:8000` 
You can change the exact port (i.e. the 8000 part) to any other number.
You will need to install the php server (`sudo apt install php8.3-cli`)<br/>
This program has *not* been tested on windows, but subject to setting up a PHP local server on windows, it should also work seamlessly there. Read [this](https://absprog.com/post/php-local-dev-server-windows11) manual for more information.<br/>
Go to `localhost:8000` on your web-browser. If you are using audio/video questions, it is recommended that you enable both audio and video autoplay on your browser for the `localhost` server only.

## Usage
You are the host of the jeopardy game. Your job is to create questions and answers and the program will store them in a pre-defined format.

### Making the questions
When you first visit `localhost:8000` you will be directed to a table with 5 topics (an example jeopardy game is already there). Click on "Edit Table" in the right panel to make the quiz editable.<br/>
When you click on any question now, you will be taken to an edit page, where you can type/change the questions and answers.

### Playing the game
Click Home to return to the starting page at any time. Once you "Commit Table", click on "reset game" at the top-right of the screen. You are now ready to play jeopardy!
Click any question. ONLY the question will be displayed. After a player gives the answer, click on the answer to verify. If they got it right, click on the '+' sign on their name in the right-side panel. If they got it wrong, click the '-' sign.<br/>
The correct score for that question will automatically be added/subtracted.

### Players
You can edit player names and number by changing the list in just one php file.<br/>
Open the `floating_table_logic.php` file and edit the list with player names (by default it just says 'Player 1', 'Player 2', ...)
Write the player names instead and make the list. The game works best (GUI-wise) with 2-4 players).

### Hard Reset
You can clear all data (questions and answers) by removing all the content in the `data` folder contained here. Do not remove the `data` folder itself.<br/>

## Limitations
- The program currently only allows one audio, video and image file per question (and one similar set for the answer). You can merge multiple images into one.
- You cannot have hyperlinks or formatting (bold, italics, etc.) in the questions as of yet

## Disclaimer
- This is just a fun program to host jeopardy with family. I have used ChatGPT to write pats of the code
- This code is a security nightmare. The assumption is that the same computer will be the host (server) and the client. **Do NOT host thist program on any server from where it is directly accessible to the internet**
