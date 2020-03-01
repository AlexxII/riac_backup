class PollConstructor {
  constructor(config) {
    if (this.verifyPollConfigStructure(config)) {
      this.id = config.id;
      this._title = config.title;
      this._code = config.code;
      this.questions = config.questions;
      this.numberOfQuestions = config.questions;
      this.renderPollHeader();
      this.renderListTmpl();
      this.renderGridTmpl();
      this.renderPollInfo();
      this.REORDER_QUESTIONS_URL = '/polls/construct/reorder-questions';
      this.SAVE_LOGIC_URL = '/polls/construct/save-poll-logic';
    }
  }

  set questions(tempQuestions) {
    let tempQuestionsArray = {};
    tempQuestions.forEach(function (val, index) {
      tempQuestionsArray[val.id] = new CQuestion(val);
    });
    this._questions = tempQuestionsArray;
  }

  get questions() {
    let tempArray = [];
    let index = 0;
    for (let key in this._questions) {
      tempArray[index] = this._questions[key];
      index++;
    }
    this.sortByOldOrder(tempArray);
    return tempArray;
  }

  set numberOfQuestions(questions) {
    this._numberOfQuestions = questions.length
  }

  set title(title) {
    this._title = title;
  }

  get title() {
    return this._title;
  }

  get numberOfQuestions() {
    return this._numberOfQuestions;
  }

  get code() {
    return this._code;
  }

  findQuestionById(id) {
    let questions = this._questions;
    if (questions[id] !== undefined) return questions[id];
    return false;
  }

  renderPollHeader() {
    let titlePlacement = document.getElementById('poll-title');
    let hNode = document.createElement('h4');
    let title = document.createTextNode(this.code);
    hNode.appendChild(title);
    titlePlacement.appendChild(hNode);
  }

  renderPollInfo() {
    let hNode = document.createElement('span');
    let numOfAnswers = this.numOfAnswers;
    let numOfQuestions = document.createTextNode(this.code);
    let questions = this._questions;
    let numberOfAnswers = 0;
    for (let key in questions) {
      numberOfAnswers += questions[key].numberOfAnswers;
    }
    // serviceNode.appendChild();
    this.numberOfAnswers = numberOfAnswers;
  }

  renderListTmpl() {
    let Obj = this;
    let listView = document.createElement('div');
    listView.className = 'list';
    let vListView = document.createElement('div');
    vListView.className = 'visible-list';
    let hListView = document.createElement('div');
    hListView.className = 'hide-list';
    listView.appendChild(vListView);
    listView.appendChild(hListView);
    let questions = this.questions;
    let visCount = 1, skipCount = 1, questionNode;
    for (let qId in questions) {
      let question = questions[qId];
      if (question.visible === 1) {
        questionNode = question.renderCQuestionList(visCount);
        visCount++;
        vListView.append(questionNode);
      }
    }
    for (let key in questions) {
      if (questions[key].visible === 0) {
        let hr = document.createElement('hr');
        hListView.appendChild(hr);
        break;
      }
    }
    questions.forEach(function (question, index) {
      if (question.visible === 0) {
        questionNode = question.renderCQuestionList(skipCount);
        skipCount++;
        hListView.appendChild(questionNode);
      }
    });
    let oldOrder;
    // изменение порядка
    this.sortable = new Sortable(vListView, {
      animation: 150,
      onStart: function (evt) {
        Obj._oldOrder = Obj.sortable.toArray();
      },
      onUpdate: function (evt) {
        NProgress.start();
        let newOrder = Obj.sortable.toArray();
        Obj.saveListReorder(newOrder);
        let items = evt.from.children;
        for (let i = 0, child; child = items[i]; i++) {
          child.querySelector('.question-order').innerHTML = (i + 1);
        }
      },
    });
    this.hSortable = new Sortable(hListView, {
      selectedClass: 'selected',
      animation: 150,
      sort: false
    });
    Obj._pollListView = listView;
  }

  saveListReorder(questionsArr) {
    let url = this.REORDER_QUESTIONS_URL;
    let Obj = this;
    let questions = this._questions;
    let sortable = this.sortable;
    $.ajax({
      url: url,
      method: 'post',
      data: {
        questions: questionsArr
      }
    }).done(function (response) {
      if (!response.code) {
        let oldOrder = Obj._oldOrder;
        sortable.sort(oldOrder);                                                          // восстанавливаем порядок
        Obj.pasteOldNum(sortable);
        NProgress.done();
        var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Изменить порядок не удалось';
        initNoty(tText, 'warning');
        console.log(response.data.message + ' ' + response.data.data);
        return;
      }
      NProgress.done();
      let newOrder = sortable.toArray();
      newOrder.forEach(function (val, index) {
        questions[val].newOrder = index;
      });
      Obj.renderGridTmpl();
    }).fail(function () {
      let oldOrder = Obj._oldOrder;
      sortable.sort(oldOrder);                                                          // восстанавливаем порядок
      Obj.pasteOldNum(sortable);
      NProgress.done();
      var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Изменить порядок не удалось';
      initNoty(tText, 'warning');
      console.log('Не удалось получить ответ сервера. Примените отладочную панель, оснаска "Сеть"');
    });
  }

  renderGridTmpl() {
    let gridDiv = document.createElement('div');
    gridDiv.id = 'grid-poll-order';
    gridDiv.className = 'grid';
    let questions = this.questions;
    let visQuestions = 1;
    for (let qId in questions) {
      let question = questions[qId];
      if (question.renderCQuestionGrid()) {
        gridDiv.appendChild(question.renderCQuestionGrid(visQuestions));
        visQuestions++;
      }
    }
    // изменение порядка
    let oldOrder;
    let Obj = this;
    this.sortableGrid = new Sortable(gridDiv, {
      multiDrag: true,
      selectedClass: 'multi-selected',
      animation: 150,
      group: 'poll-grid-store',
      onStart: function (evt) {
        Obj._oldOrder = Obj.sortableGrid.toArray();
      },
      onUpdate: function (evt) {
        NProgress.start();
        let newOrder = Obj.sortableGrid.toArray();
        Obj.saveGridReorder(newOrder);
        let items = evt.from.children;
        for (let i = 0, child; child = items[i]; i++) {
          child.querySelector('.question-order').innerHTML = (i + 1);
        }
      }
    });
    Obj._pollGridView = gridDiv;
  }

  saveGridReorder(questionsArr) {
    let url = this.REORDER_QUESTIONS_URL;
    let Obj = this;
    let questions = this._questions;
    let sortable = this.sortableGrid;
    $.ajax({
      url: url,
      method: 'post',
      data: {
        questions: questionsArr
      }
    }).done(function (response) {
      if (!response.code) {
        let oldOrder = Obj._oldOrder;
        sortable.sort(oldOrder);                                                          // восстанавливаем порядок
        Obj.pasteOldNum(sortable);
        NProgress.done();
        var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Изменить порядок не удалось';
        initNoty(tText, 'warning');
        console.log(response.data.message + ' ' + response.data.data);
        return;
      }
      NProgress.done();
      let newOrder = sortable.toArray();
      newOrder.forEach(function (val, index) {
        questions[val].newOrder = index;
      });
      Obj.renderListTmpl();
    }).fail(function () {
      let oldOrder = Obj._oldOrder;
      sortable.sort(oldOrder);                                                          // восстанавливаем порядок
      Obj.pasteOldNum(sortable);
      NProgress.done();
      var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Изменить порядок не удалось';
      initNoty(tText, 'warning');
      console.log('Не удалось получить ответ сервера. Примените отладочную панель, оснаска "Сеть"');
    });
  }

  pasteOldNum(obj) {
    let items = obj.el.children;
    for (let i = 0, child; child = items[i]; i++) {
      child.querySelector('.question-order').innerHTML = (i + 1);
    }
  }

  hideQuestionInListView(id) {
    let Obj = this;
    let question = this.findQuestionById(id);
    let hSortDiv = Obj.hSortable.el;
    let sortDiv = Obj.sortable.el;
    if (question) {
      question.hideQuestion(function () {
        if (hSortDiv.getElementsByTagName('hr').length === 0) {
          let hr = document.createElement('hr');
          hSortDiv.appendChild(hr);
        }
        let tmpl = question.questionListTmpl;

        tmpl.querySelector('.question-hide').style.display = 'none';
        tmpl.querySelector('.restore-question').style.display = 'inline';
        hSortDiv.appendChild(tmpl);
      });
    }
    setTimeout(() => Obj.reindex(), 300);
  }

  restoreQuestionInListView(id) {
    let Obj = this;
    let question = this.findQuestionById(id);
    let hSortDiv = Obj.hSortable.el;
    let sortDiv = Obj.sortable.el;
    if (question) {
      question.restoreQuestion(function () {
        if (hSortDiv.getElementsByTagName('hr').length === 0) {
          let hr = document.createElement('hr');
          hSortDiv.appendChild(hr);
        }
        let tmpl = question.questionListTmpl;
        tmpl.querySelector('.restore-question').style.display = 'none';
        tmpl.querySelector('.question-hide').style.display = 'inline';
        sortDiv.appendChild(tmpl);
      });
    }
    setTimeout(() => Obj.resort(), 300);
  }

  reindex() {
    let sortDiv = this.sortable.el;
    let questionArray = sortDiv.getElementsByClassName('question-order');
    Array.prototype.map.call(questionArray, function (span, index) {
      span.textContent = ++index + '';
    });
    let hSortDiv = this.hSortable.el;
    let questionArrayEx = hSortDiv.getElementsByClassName('question-order');
    if (questionArrayEx.length !== 0) {
      Array.prototype.map.call(questionArrayEx, function (span, index) {
        span.textContent = ++index + '';
      });
    } else {
      let hr = hSortDiv.getElementsByTagName('hr')[0];
      hr.remove();
    }
  }

  resort() {
    let questions = this.questions;
    let ar = [];
    this.sortByOldOrder(questions);
    questions.forEach(function (question, index) {
      ar[index] = question.id;
    });
    let sortable = this.sortable;
    sortable.sort(ar);
    this.reindex();
  }

  get pollListView() {
    return this._pollListView;
  }

  get pollGridView() {
    return this._pollGridView;
  }

  renderListView() {
    return this.pollListView;
  }

  renderGridView() {
    return this.pollGridView;
  }

  renderLogicMenu(questionObj, answerObj) {
    let Obj = this;
    let menuDiv = document.createElement('div');
    menuDiv.id = 'logic-menu-content';
    let questions = this.questions;
    for (let qId in questions) {
      let question = questions[qId];
      menuDiv.appendChild(question.questionTmplEx);
    }
    questionObj.tempTmpl.classList.add('selected-answer');
    answerObj.tempTmpl.classList.add('selected-question');
    Obj.buffer = answerObj;
    // if (question.answersEx[id] !== undefined) {
    //   Obj.buffer = question.answersEx[id];
    //   question.answersEx[id].tempTmpl.classList.add('selected-answer');
    //   question.tempTmpl.classList.add('selected-question');
    //
    //   console.log(question.answersEx[id]);
    // }


    return menuDiv;
  }

  showLogicMenu(answerId, questionId) {
    let Obj = this;
    let questionObj = Obj._questions[questionId];
    let answerObj = questionObj[answerId];
    $.alert({
      title: Obj.code + ' ' + 'исключить ответы',
      content: Obj.renderLogicMenu(questionObj, answerObj),
      columnClass: 'col-md-12',
      animateFromElement: false,
      buttons: {
        ok: {
          text: 'Сохранить',
          btnClass: 'btn-success',
          action: function () {
            Obj.confirmLogic(answerObj);
          }
        },
        cancel: {
          text: 'Отмена',
          action: function () {
            Obj.abortLogic();
          }
        }
      }
    });
  };

  confirmLogic(answerObj) {
    let menu = document.getElementById('logic-menu-content');
    let inputs = menu.getElementsByTagName('input');
    let result = [];
    Array.prototype.map.call(inputs, function (val) {
      if (val.checked) {
        result.push(val.dataset.id);
        val.checked = false;                                          // снимаем checkbox
      }
    });
    this.saveLogic(result, answerObj.id);
  }

  abortLogic() {
    // let menu = document.getElementById('logic-menu-content');
    // this.clearCheckboxes(menu);
  }

  saveLogic(result, id) {
    let Obj = this;
    if (result.length !== 0){
      let url = this.SAVE_LOGIC_URL;
      $.ajax({
        url: url,
        method: 'post',
        data: {
          restrict: result,
          pollId : Obj.id,
          answer: id
        }
      }).done(function (response) {
        if (!response.code) {
          var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Сохранить логику не удалось';
          initNoty(tText, 'warning');
          console.log(response.data.message + ' ' + response.data.data);
          return;
        }

        let answerObj = Obj.buffer;
        answerObj.logicArray = result;
        answerObj.answerTmpl.appendChild(answerObj.renderBranchSymbl());

        var tText = '<span style="font-weight: 600">Успех!</span><br>Логика сохранена';
        initNoty(tText, 'success');
      }).fail(function () {
        var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Сохранить логику не удалось';
        initNoty(tText, 'warning');
        console.log('Не удалось получить ответ сервера. Примените отладочную панель, оснаска "Сеть"');
      });
    }
  }

  clearCheckboxes(menu) {
    let inputs = menu.getElementsByTagName('input');
    for (let key in inputs) {
      inputs[key].checked = false;
    }
  }

  verifyPollConfigStructure(val) {
    return val !== null;
  }

  verifyId(val) {
    return true;
  }

  sortByOldOrder(arr) {
    arr.sort((a, b) => a.newOrder > b.newOrder ? 1 : -1);
  }

}