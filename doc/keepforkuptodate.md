## How to keep a fork up to date

### 1. Clone your fork:

    git clone git@github.com:YOUR-USERNAME/YOUR-FORKED-REPO.git

### 2. Add remote from original repository in your forked repository: 

    cd into/cloned/fork-repo
    git remote add upstream git://github.com/ORIGINAL-DEV-USERNAME/REPO-YOU-FORKED-FROM.git
    git fetch upstream

### 3. Updating your fork from original repo to keep up with their changes:

    git pull upstream master
    
### 4. Push changes to your fork

    git push

source (https://gist.github.com/CristinaSolana/1885435)[https://gist.github.com/CristinaSolana/1885435]

