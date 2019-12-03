var toTemplateNum = {
  '1': {                              // Тип шаблона (int)
    '1': 'Круглосуточный'
  },
  '2': {
    '1': [1, 2, 3, 4, 5, 6, 7]		    // день недели
  },
  '3': {                              // Сколько часов прибавлять (продолжительность рабочего дня)
    '1': 24
  },
  '4': {
    '1': {                            // периоды не подсчета
      'start': '12.12.2012',
      'end': '13.01.2013'
    },
    '2': {				                    // точки не подсчета
      'start': '12.12.2012',
      'end': '12.12.2012'
    }
  },
  '5': {
    '1': {
      'id': '231242342143'	          // id оборудования, которое участвует в сеансах связи
    }
  },
  '6': {
    '1': {
      'to_date': '12.03.2019'
    },
    '2': {
      'duration': 2		                // продолжительность включения
    },
    '3': {
      'duration': 1		                // продолжительность отключения
    },
  }
};

var toTemplate = {
  'title': {                          // Тип шаблона (int)
    '1': 'Круглосуточный'
  },
  'days': {                           // день недели
    '1': [1, 2, 3, 4, 5, 6, 7]
  },
  'hours': {                          // Сколько часов прибавлять (продолжительность рабочего дня)
    '1': 24
  },
  'holidays': {                              // периоды или точки не подсчета
    '1': {
      'start': '12.12.2012',
      'end': '13.01.2013'
    },
    '2': {
      'start': '12.12.2012',
      'end': '12.12.2012'
    }
  },
  'sessions': {                              // id оборудования, которое участвует в сеансах связи
    '1': {
      'eq_id': '231242342143'
    }
  },
  'to': {                              // Проведение ТО
    'date': {
      'eq_id': '12.03.2019'           // автоматически из графика ТО
    },
    'on': {
      'duration': 2		                // продолжительность включения
    },
    'off': {
      'duration': 1		                // продолжительность отключения
    }
  }
};