# CityBuilder
Final project for CSCI3230U; a web application where users can watch their cities grow.

# Abstract
CityBuilder is a web application that allows users to create and grow their own
cities. They can choose to develop one of four sectors: residences, education,
recreation, or business. Sectors can be developed immediately by refreshing the
page or allowed to expand in real time. As the user's city improves it
will be given a description based on how the user has chosen to develop it.

# Setup
To initialize the database, please run scripts/database.php.

# Game rules
The game progresses in 1 minute intervals. It operates on a currency of
'blocks.' Each city starts with a certain number of blocks, which are consumed
to expand sectors. The selected sector grows by 1 block for each refresh,
and 1 block for each minute passed.