# quiz-maker

Quiz-Maker is a small command line tool to convert csv files containing quizes to ready to print pdf files.

It is rather straightforward to use.

```
./quiz-maker.phar generate input.csv output.pdf
```

This will generate a PDF from the csv.
## CSV format
Use the following format in your csv file.
```
Question,Answer1,Answer2,Answer3,Correct,Image
Vad är skalmans viktigaste uppfinning?,Självgående skottkärran,Mat och sovklockan,Sin helikopter,2,
Vad är Dalarna?,Ett län,Ett land,En by,1,http://www.lansstyrelsen.se/dalarna/SiteCollectionImages/Sv/djur-och-natur/skyddad-natur/hela-lanet-400px.gif
```


## Styling

Upcoming version will let you manually choose a css file. For now you need to rebuild the project after changing the question.css file.





## Building

Being lazy i have used [phar/composer](https://github.com/clue/phar-composer) to generate the executable. So after making changes to the source-code, simply rebuild it like this:
 ```
 phar-composer.phar build /path/to/quiz-maker

```

## Dependencies

You need wkhtmltopdf to use this tool. if not found it will not generate any PDFs.

## Sidenote :)

This tool was easily built using the dalnix/dalnix-cli command-line-tool-builder. And you know what? It was dead easy. Allthough not released as yet as there are some kinks to straighten out.
